<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PaymentGatewayService
{
    public function sePayConfigured(): bool
    {
        $config = config('payment-gateways.sepay');

        return (bool) ($config['enabled'] ?? false)
            && !empty($config['bank_short_name'])
            && !empty($config['bank_account_number'])
            && !empty($config['bank_account_holder_name']);
    }

    public function ensureSePayPayment(Booking $booking): Payment
    {
        $payment = Payment::query()
            ->where('booking_id', (string) $booking->getKey())
            ->where('method', 'sepay')
            ->latest()
            ->first();

        if ($payment !== null && in_array($payment->status, ['pending', 'success'], true)) {
            return $payment;
        }

        return Payment::create([
            'booking_id' => (string) $booking->getKey(),
            'method' => 'sepay',
            'amount' => (int) $booking->total_price,
            'transaction_code' => $this->sePayOrderCode($booking),
            'payment_date' => null,
            'status' => 'pending',
        ]);
    }

    public function createSePayInfo(Booking $booking, Payment $payment): array
    {
        $config = config('payment-gateways.sepay');
        $orderCode = (string) $payment->transaction_code;
        $amount = (int) $booking->total_price;

        $info = [
            'provider' => 'sepay',
            'bank_name' => $config['bank_short_name'] ?? '',
            'bank_short_name' => $config['bank_short_name'] ?? '',
            'account_number' => $config['bank_account_number'] ?? '',
            'account_holder_name' => $config['bank_account_holder_name'] ?? '',
            'amount' => $amount,
            'order_code' => $orderCode,
            'transfer_content' => $orderCode,
            'qr_code_url' => $this->vietQrUrl($amount, $orderCode),
            'expired_at' => null,
        ];

        if (!($config['enabled'] ?? false) || empty($config['api_token']) || empty($config['bank_account_id'])) {
            return $info;
        }

        try {
            $response = Http::timeout(8)
                ->withToken((string) $config['api_token'])
                ->asJson()
                ->post('https://userapi.sepay.vn/v2/bank-accounts/' . $config['bank_account_id'] . '/orders', [
                    'amount' => $amount,
                    'order_code' => $orderCode,
                    'with_qrcode' => '1',
                ]);

            if ($response->successful()) {
                $data = $response->json('data') ?? [];
                $info['qr_code_url'] = $data['qr_code_url'] ?? $data['qr_code'] ?? $info['qr_code_url'];
                $info['expired_at'] = $data['expired_at'] ?? null;
            }
        } catch (\Throwable) {
            // Keep the deterministic VietQR fallback usable if SePay API is temporarily unavailable.
        }

        return $info;
    }

    public function normalizeSePayWebhook(array $payload): array
    {
        $content = $this->pickString($payload['content'] ?? null)
            ?? $this->pickString($payload['transaction_content'] ?? null);
        $code = $this->pickString($payload['code'] ?? null)
            ?? $this->pickString($payload['payment_code'] ?? null)
            ?? $this->extractSePayOrderCode($content);
        $transferType = $this->pickString($payload['transferType'] ?? null)
            ?? $this->mapTransferType($this->pickString($payload['transfer_type'] ?? null));

        return [
            'transaction_id' => $this->pickString($payload['id'] ?? null)
                ?? $this->pickString($payload['transaction_id'] ?? null),
            'reference_code' => $this->pickString($payload['referenceCode'] ?? null)
                ?? $this->pickString($payload['reference_code'] ?? null)
                ?? $this->pickString($payload['reference_number'] ?? null),
            'transfer_type' => $transferType,
            'transfer_amount' => $this->toNumber($payload['transferAmount'] ?? $payload['amount'] ?? $payload['amount_in'] ?? null),
            'code' => $code,
            'content' => $content,
            'transaction_date' => $this->pickString($payload['transactionDate'] ?? null)
                ?? $this->pickString($payload['transaction_date'] ?? null),
            'raw' => $payload,
        ];
    }

    public function verifySePayWebhookSecret(?string $receivedSecret): bool
    {
        $expected = (string) config('payment-gateways.sepay.webhook_secret', '');

        return $expected === '' || hash_equals($expected, (string) $receivedSecret);
    }

    public function createVnpayUrl(Booking $booking): ?string
    {
        $config = config('payment-gateways.vnpay');

        if (
            !($config['enabled'] ?? false)
            || empty($config['tmn_code'])
            || empty($config['hash_secret'])
            || empty($config['url'])
        ) {
            return null;
        }

        $params = [
            'vnp_Version' => $config['version'] ?? '2.1.0',
            'vnp_Command' => 'pay',
            'vnp_TmnCode' => $config['tmn_code'],
            'vnp_Amount' => ((int) $booking->total_price) * 100,
            'vnp_CurrCode' => $config['currency'] ?? 'VND',
            'vnp_TxnRef' => (string) $booking->getKey() . '-' . Str::upper(Str::random(8)),
            'vnp_OrderInfo' => 'Thanh toan don ve ' . $booking->qr_code,
            'vnp_OrderType' => 'billpayment',
            'vnp_Locale' => $config['locale'] ?? 'vn',
            'vnp_ReturnUrl' => $config['return_url'] ?? url('/thanh-toan/return/vnpay'),
            'vnp_IpnUrl' => $config['ipn_url'] ?? url('/thanh-toan/ipn/vnpay'),
            'vnp_IpAddr' => request()->ip() ?? '127.0.0.1',
            'vnp_CreateDate' => Carbon::now()->format('YmdHis'),
        ];

        ksort($params);

        $query = http_build_query($params, '', '&', PHP_QUERY_RFC3986);
        $secureHash = hash_hmac('sha512', urldecode($query), (string) $config['hash_secret']);

        return rtrim((string) $config['url'], '?') . '?' . $query . '&vnp_SecureHash=' . $secureHash;
    }

    public function verifyVnpayReturn(array $payload): bool
    {
        $config = config('payment-gateways.vnpay');
        $secureHash = (string) ($payload['vnp_SecureHash'] ?? '');

        if ($secureHash === '' || empty($config['hash_secret'])) {
            return false;
        }

        $data = $payload;
        unset($data['vnp_SecureHash'], $data['vnp_SecureHashType']);
        ksort($data);

        $query = http_build_query($data, '', '&', PHP_QUERY_RFC3986);
        $expected = hash_hmac('sha512', urldecode($query), (string) $config['hash_secret']);

        return hash_equals($expected, $secureHash);
    }

    public function isSuccessfulVnpayReturn(array $payload): bool
    {
        return ($payload['vnp_ResponseCode'] ?? null) === '00'
            && ($payload['vnp_TransactionStatus'] ?? null) === '00';
    }

    public function extractVnpayBookingId(array $payload): ?string
    {
        $txnRef = (string) ($payload['vnp_TxnRef'] ?? '');

        if ($txnRef === '') {
            return null;
        }

        return explode('-', $txnRef, 2)[0] ?: null;
    }

    private function sePayOrderCode(Booking $booking): string
    {
        $rawId = strtoupper(preg_replace('/[^A-Z0-9]/', '', (string) $booking->getKey()));

        return 'BETA' . substr($rawId . now()->format('His'), 0, 28);
    }

    private function vietQrUrl(int $amount, string $orderCode): string
    {
        $config = config('payment-gateways.sepay');
        $bankShortName = (string) ($config['bank_short_name'] ?? '');
        $accountNumber = (string) ($config['bank_account_number'] ?? '');

        $query = http_build_query([
            'amount' => $amount,
            'addInfo' => $orderCode,
            'accountName' => (string) ($config['bank_account_holder_name'] ?? ''),
        ], '', '&', PHP_QUERY_RFC3986);

        return 'https://img.vietqr.io/image/' . rawurlencode($bankShortName) . '-' . rawurlencode($accountNumber) . '-compact2.png?' . $query;
    }

    private function extractSePayOrderCode(?string $content): ?string
    {
        if (!$content) {
            return null;
        }

        preg_match('/BETA[A-Z0-9]{8,32}/', strtoupper($content), $match);

        return $match[0] ?? null;
    }

    private function pickString(mixed $value): ?string
    {
        if (is_string($value)) {
            $value = trim($value);

            return $value !== '' ? $value : null;
        }

        if (is_numeric($value)) {
            return (string) $value;
        }

        return null;
    }

    private function toNumber(mixed $value): ?int
    {
        if (is_numeric($value)) {
            return (int) $value;
        }

        return null;
    }

    private function mapTransferType(?string $value): ?string
    {
        return match ($value) {
            'credit' => 'in',
            'debit' => 'out',
            default => $value,
        };
    }
}

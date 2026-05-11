<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Support\Facades\Http;

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

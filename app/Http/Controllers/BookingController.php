<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Movie;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Seat;
use App\Models\Showtime;
use App\Services\MovieCatalog;
use App\Services\PaymentGatewayService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function __construct(
        private readonly MovieCatalog $catalog,
        private readonly PaymentGatewayService $payments
    )
    {
    }

    public function show(Request $request, string $id)
    {
        $this->releaseExpiredHolds();

        $movie = $this->catalog->findMovieBySlug($id) ?? abort(404);
        $selectedDate = trim((string) $request->query('date', $movie['releaseDate'] ?? now()->format('d/m/Y')));
        $selectedTime = trim((string) $request->query('time', '19:00'));
        $selectedFormat = trim((string) $request->query('format', '2D Phụ đề'));
        $selectedShowtimeId = trim((string) $request->query('showtime', ''));
        $showtime = $this->resolveShowtime($movie, $selectedDate, $selectedTime, $selectedFormat, $selectedShowtimeId);

        return view('seat-selection', [
            'title' => 'Đặt vé - ' . ($movie['title'] ?? 'Beta Cinemas'),
            'movie' => $movie,
            'selectedDate' => $selectedDate,
            'selectedTime' => $selectedTime,
            'selectedFormat' => $selectedFormat,
            'selectedShowtimeId' => (string) $showtime->getKey(),
            'selectedTicketPrice' => (int) $showtime->price,
            'seatRows' => $this->seatRows(),
            'soldSeats' => $this->soldSeats($showtime),
            'heldSeats' => $this->heldSeats($showtime),
            'reservedSeats' => [],
            'preselectedSeats' => [],
        ]);
    }

    public function store(Request $request, string $id)
    {
        $this->releaseExpiredHolds();

        $demoUser = session('demo_user');

        if (! auth()->check() && (! is_array($demoUser) || empty($demoUser['email']))) {
            return redirect()->to(route('auth.login.form') . '#login')
                ->with('status', 'Vui lòng đăng nhập trước khi tiếp tục đặt vé.');
        }

        $movie = $this->catalog->findMovieBySlug($id) ?? abort(404);
        $validated = $request->validate([
            'show_date' => ['required', 'string', 'max:40'],
            'show_time' => ['required', 'string', 'max:20'],
            'format' => ['nullable', 'string', 'max:60'],
            'showtime_id' => ['required', 'string'],
            'seats' => ['required', 'string', 'max:255'],
            'customer_name' => ['nullable', 'string', 'max:120'],
            'customer_email' => ['nullable', 'email', 'max:120'],
            'customer_phone' => ['nullable', 'string', 'max:40'],
        ]);

        $seatCodes = $this->normalizeSeatCodes($validated['seats']);
        if ($seatCodes === []) {
            return back()->withErrors(['seats' => 'Vui lòng chọn ít nhất 1 ghế.'])->withInput();
        }

        $showtime = $this->resolveShowtime(
            $movie,
            $validated['show_date'],
            $validated['show_time'],
            $validated['format'] ?? '2D Phụ đề',
            $validated['showtime_id']
        );
        $seats = $this->resolveSeats($showtime->room, $seatCodes);
        $conflicts = $this->conflictingSeats($showtime, $seats->map(fn (Seat $seat) => (string) $seat->getKey())->all());

        if ($conflicts !== []) {
            abort(409, 'Ghế đã được đặt: ' . implode(', ', $conflicts));
        }

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'showtime_id' => (string) $showtime->getKey(),
            'total_price' => $seats->count() * (int) $showtime->price,
            'payment_status' => 'pending',
            'booking_status' => 'booked',
            'customer_name' => $validated['customer_name'] ?? auth()->user()?->name ?? ($demoUser['name'] ?? null),
            'customer_email' => $validated['customer_email'] ?? auth()->user()?->email ?? ($demoUser['email'] ?? null),
            'customer_phone' => $validated['customer_phone'] ?? null,
            'qr_code' => 'BK-' . strtoupper(Str::random(10)),
            'hold_expires_at' => now()->addMinutes(10),
        ]);

        foreach ($seats as $seat) {
            BookingSeat::create([
                'booking_id' => (string) $booking->getKey(),
                'seat_id' => (string) $seat->getKey(),
                'price' => (int) $showtime->price,
            ]);
        }

        return redirect()
            ->route('bookings.payment', ['booking' => (string) $booking->getKey()])
            ->with('status', 'Đặt vé thành công. Vui lòng thanh toán để hoàn tất đơn vé.');
    }

    public function paymentPage(string $bookingId)
    {
        $this->releaseExpiredHolds();

        $booking = Booking::query()
            ->with(['showtime.movie', 'showtime.room', 'seats.seat'])
            ->findOrFail($bookingId);

        $this->authorizeBooking($booking);
        abort_if($booking->booking_status === 'expired', 410, 'Đơn vé đã hết thời gian giữ ghế. Vui lòng đặt lại.');

        return view('payment-page', [
            'title' => 'Thanh toán - Beta Cinemas',
            'booking' => $booking,
            'sepayConfigured' => $this->payments->sePayConfigured(),
            'sepayPayment' => $sepayPayment = $this->payments->ensureSePayPayment($booking),
            'sepayInfo' => $this->payments->createSePayInfo($booking, $sepayPayment),
            'vnpayUrl' => $this->payments->createVnpayUrl($booking),
        ]);
    }

    public function confirmPayment(Request $request, string $bookingId)
    {
        $booking = Booking::query()->findOrFail($bookingId);
        $this->releaseExpiredHolds();
        $this->authorizeBooking($booking);
        abort_if($booking->booking_status === 'expired', 410, 'Đơn vé đã hết thời gian giữ ghế. Vui lòng đặt lại.');

        if ($booking->payment_status === 'paid') {
            return redirect()
                ->route('account.show', ['tab' => 'history'])
                ->with('status', 'Đơn vé này đã được thanh toán.');
        }

        $method = (string) $request->input('method', 'sepay');

        if ($method === 'sepay') {
            $this->payments->ensureSePayPayment($booking);
            $this->refreshHold($booking);
            $booking->forceFill(['payment_status' => 'pending_gateway'])->save();

            return redirect()
                ->route('bookings.payment', ['booking' => (string) $booking->getKey()])
                ->with('status', 'Đơn vé đang chờ thanh toán SePay. Vui lòng chuyển khoản đúng nội dung hiển thị.');
        }

        $paymentUrl = $this->payments->createVnpayUrl($booking);

        Payment::create([
            'booking_id' => (string) $booking->getKey(),
            'method' => 'vnpay',
            'amount' => (int) $booking->total_price,
            'transaction_code' => 'VNP-' . strtoupper(Str::random(12)),
            'payment_date' => now(),
            'status' => $paymentUrl ? 'pending' : 'success',
        ]);

        if ($paymentUrl) {
            $this->refreshHold($booking);
            $booking->forceFill(['payment_status' => 'pending_gateway'])->save();

            return redirect()->away($paymentUrl);
        }

        $booking->forceFill([
            'payment_status' => 'paid',
            'booking_status' => 'booked',
            'hold_expires_at' => null,
        ])->save();

        return redirect()
            ->route('account.show', ['tab' => 'history'])
            ->with('status', 'Đã mô phỏng thanh toán VNPay thành công cho đơn vé ' . $booking->qr_code . '.');
    }

    public function sePayWebhook(Request $request)
    {
        $authorization = (string) $request->header('Authorization', '');
        $receivedSecret = (string) ($request->header('X-Secret-Key') ?: preg_replace('/^apikey\s+/i', '', $authorization));

        if (! $this->payments->verifySePayWebhookSecret(trim($receivedSecret))) {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        $payload = $this->payments->normalizeSePayWebhook($request->all());
        Log::info('SePay webhook received', [
            'payload' => $payload,
            'headers' => [
                'authorization_present' => $authorization !== '',
                'x_secret_present' => $request->header('X-Secret-Key') !== null,
            ],
        ]);

        if (! in_array($payload['transfer_type'], ['in', 'credit'], true) || empty($payload['code'])) {
            Log::warning('SePay webhook ignored', [
                'reason' => 'missing_or_non_credit',
                'payload' => $payload,
            ]);

            return response()->json(['status' => 'ignored', 'reason' => 'missing_or_non_credit']);
        }

        $payment = Payment::query()
            ->where('method', 'sepay')
            ->where('transaction_code', $payload['code'])
            ->latest()
            ->first();

        if ($payment === null) {
            Log::warning('SePay webhook ignored', [
                'reason' => 'payment_not_found',
                'code' => $payload['code'],
            ]);

            return response()->json(['status' => 'ignored', 'reason' => 'payment_not_found']);
        }

        if (($payload['transfer_amount'] ?? 0) < (int) $payment->amount) {
            Log::warning('SePay webhook ignored', [
                'reason' => 'amount_mismatch',
                'expected' => (int) $payment->amount,
                'actual' => $payload['transfer_amount'] ?? null,
                'code' => $payload['code'],
            ]);

            return response()->json(['status' => 'ignored', 'reason' => 'amount_mismatch']);
        }

        $booking = Booking::query()->find((string) $payment->booking_id);
        if ($booking === null) {
            return response()->json(['status' => 'ignored', 'reason' => 'booking_not_found']);
        }

        if ($booking->booking_status === 'expired' || ($booking->hold_expires_at !== null && $booking->hold_expires_at->lt(now()))) {
            $booking->forceFill(['booking_status' => 'expired'])->save();

            return response()->json(['status' => 'ignored', 'reason' => 'booking_expired']);
        }

        $payment->forceFill([
            'status' => 'success',
            'payment_date' => now(),
        ])->save();

        $booking->forceFill([
            'payment_status' => 'paid',
            'booking_status' => 'booked',
            'hold_expires_at' => null,
        ])->save();

        return response()->json(['status' => 'ok']);
    }

    public function paymentReturn(Request $request)
    {
        $payload = $request->all();
        $bookingId = $this->payments->extractVnpayBookingId($payload);

        if (! $this->payments->verifyVnpayReturn($payload) || $bookingId === null) {
            return redirect()->route('account.show', ['tab' => 'history'])
                ->with('status', 'Xác thực thanh toán VNPay không hợp lệ.');
        }

        $booking = Booking::query()->find($bookingId);
        if ($booking === null) {
            return redirect()->route('account.show', ['tab' => 'history'])
                ->with('status', 'Không tìm thấy đơn vé sau thanh toán.');
        }

        if (! $this->payments->isSuccessfulVnpayReturn($payload)) {
            $payment = Payment::query()
                ->where('booking_id', (string) $booking->getKey())
                ->where('method', 'vnpay')
                ->latest()
                ->first();

            if ($payment !== null) {
                $payment->forceFill(['status' => 'failed', 'payment_date' => now()])->save();
            }

            return redirect()
                ->route('bookings.payment', ['booking' => (string) $booking->getKey()])
                ->with('status', 'Thanh toán VNPay chưa thành công. Vui lòng thử lại.');
        }

        abort_if($booking->booking_status === 'expired' || ($booking->hold_expires_at !== null && $booking->hold_expires_at->lt(now())), 410, 'Đơn vé đã hết thời gian giữ ghế. Vui lòng đặt lại.');

        $booking->forceFill([
            'payment_status' => 'paid',
            'booking_status' => 'booked',
            'hold_expires_at' => null,
        ])->save();

        $payment = Payment::query()
            ->where('booking_id', (string) $booking->getKey())
            ->where('method', 'vnpay')
            ->latest()
            ->first();

        if ($payment !== null) {
            $payment->forceFill(['status' => 'success', 'payment_date' => now()])->save();
        }

        return redirect()
            ->route('account.show', ['tab' => 'history'])
            ->with('status', 'Thanh toán VNPay thành công cho đơn vé ' . $booking->qr_code . '.');
    }

    public function paymentIpn(Request $request)
    {
        $payload = $request->all();
        $bookingId = $this->payments->extractVnpayBookingId($payload);

        if (! $this->payments->verifyVnpayReturn($payload) || $bookingId === null || ! $this->payments->isSuccessfulVnpayReturn($payload)) {
            return response()->json(['status' => 'invalid'], 422);
        }

        $booking = Booking::query()->find($bookingId);
        if ($booking === null) {
            return response()->json(['status' => 'not_found'], 404);
        }

        if ($booking->booking_status === 'expired' || ($booking->hold_expires_at !== null && $booking->hold_expires_at->lt(now()))) {
            $booking->forceFill(['booking_status' => 'expired'])->save();

            return response()->json(['status' => 'expired'], 410);
        }

        $booking->forceFill([
            'payment_status' => 'paid',
            'booking_status' => 'booked',
            'hold_expires_at' => null,
        ])->save();

        return response()->json(['status' => 'ok']);
    }

    private function resolveShowtime(array $movieData, string $showDate, string $showTime, string $format, ?string $showtimeId = null): Showtime
    {
        $movie = Movie::query()->where('slug', (string) $movieData['id'])->first();
        abort_if($movie === null, 404, 'Phim này chưa có dữ liệu trong quản trị.');

        if ($showtimeId !== null && trim($showtimeId) !== '') {
            $showtime = Showtime::query()
                ->with('room')
                ->where('_id', trim($showtimeId))
                ->where('movie_id', (string) $movie->getKey())
                ->where('is_active', true)
                ->first();

            abort_if($showtime === null, 404, 'Suất chiếu không tồn tại hoặc đã ngừng bán.');
            abort_if($showtime->room === null, 422, 'Suất chiếu chưa được gắn phòng chiếu.');
            abort_if($showtime->start_time->lt(now()), 422, 'Suất chiếu đã quá giờ đặt vé.');
            $this->ensureRoomSeats($showtime->room);

            return $showtime;
        }

        $startAt = $this->parseScheduleDateTime($showDate, $showTime);
        $showtime = Showtime::query()
            ->with('room')
            ->where('movie_id', (string) $movie->getKey())
            ->where('start_time', $startAt)
            ->where('format', $format)
            ->where('is_active', true)
            ->first();

        abort_if($showtime === null, 404, 'Không tìm thấy suất chiếu do quản trị thiết lập.');
        abort_if($showtime->room === null, 422, 'Suất chiếu chưa được gắn phòng chiếu.');
        abort_if($showtime->start_time->lt(now()), 422, 'Suất chiếu đã quá giờ đặt vé.');
        $this->ensureRoomSeats($showtime->room);

        return $showtime;
    }

    private function authorizeBooking(Booking $booking): void
    {
        $demoUser = session('demo_user');
        $demoEmail = is_array($demoUser) ? (string) ($demoUser['email'] ?? '') : '';
        $authEmail = (string) (auth()->user()?->email ?? '');

        abort_unless(
            ((string) ($booking->user_id ?? '') !== '' && (string) $booking->user_id === (string) auth()->id())
            || ($authEmail !== '' && (string) $booking->customer_email === $authEmail)
            || ($demoEmail !== '' && (string) $booking->customer_email === $demoEmail),
            403
        );
    }

    private function seatRows(): array
    {
        return [
            'H' => range(11, 1),
            'G' => range(11, 1),
            'F' => range(9, 1),
            'E' => range(9, 1),
            'D' => range(10, 1),
            'C' => range(10, 1),
            'B' => range(10, 1),
            'A' => range(10, 1),
        ];
    }

    private function ensureRoomSeats(Room $room): void
    {
        foreach ($this->seatRows() as $row => $numbers) {
            foreach ($numbers as $number) {
                $code = $row . $number;
                Seat::query()->firstOrCreate(
                    ['room_id' => (string) $room->getKey(), 'seat_number' => $code],
                    ['seat_type' => in_array($row, ['A', 'B'], true) ? 'vip' : 'normal']
                );
            }
        }

        if ((int) $room->total_seats === 0) {
            $room->forceFill(['total_seats' => Seat::query()->where('room_id', (string) $room->getKey())->count()])->save();
        }
    }

    private function normalizeSeatCodes(string $seats): array
    {
        return collect(explode(',', strtoupper($seats)))
            ->map(fn (string $seat) => trim($seat))
            ->filter(fn (string $seat) => preg_match('/^[A-Z][0-9]{1,2}$/', $seat) === 1)
            ->unique()
            ->values()
            ->all();
    }

    private function resolveSeats(Room $room, array $seatCodes)
    {
        $this->ensureRoomSeats($room);

        return Seat::query()
            ->where('room_id', (string) $room->getKey())
            ->whereIn('seat_number', $seatCodes)
            ->get()
            ->keyBy('seat_number')
            ->pipe(function ($seats) use ($seatCodes) {
                abort_if($seats->count() !== count($seatCodes), 422, 'Ghế không hợp lệ.');

                return $seats->values();
            });
    }

    private function conflictingSeats(Showtime $showtime, array $seatIds): array
    {
        $bookingIds = $this->unavailableBookingIds($showtime);

        if ($bookingIds === []) {
            return [];
        }

        $bookedSeatIds = BookingSeat::query()
            ->whereIn('booking_id', $bookingIds)
            ->whereIn('seat_id', $seatIds)
            ->pluck('seat_id')
            ->all();

        if ($bookedSeatIds === []) {
            return [];
        }

        return Seat::query()
            ->whereIn('_id', $bookedSeatIds)
            ->pluck('seat_number')
            ->all();
    }

    private function soldSeats(Showtime $showtime): array
    {
        $bookingIds = $this->paidBookingIds($showtime);

        return $this->seatNumbersForBookings($bookingIds);
    }

    private function heldSeats(Showtime $showtime): array
    {
        $bookingIds = $this->activeHoldBookingIds($showtime);

        return $this->seatNumbersForBookings($bookingIds);
    }

    private function unavailableBookingIds(Showtime $showtime): array
    {
        return collect($this->paidBookingIds($showtime))
            ->merge($this->activeHoldBookingIds($showtime))
            ->unique()
            ->values()
            ->all();
    }

    private function paidBookingIds(Showtime $showtime): array
    {
        return Booking::query()
            ->where('showtime_id', (string) $showtime->getKey())
            ->where('booking_status', 'booked')
            ->where('payment_status', 'paid')
            ->get()
            ->map(fn (Booking $booking) => (string) $booking->getKey())
            ->all();
    }

    private function activeHoldBookingIds(Showtime $showtime): array
    {
        $this->normalizeMissingHoldExpiry($showtime);

        return Booking::query()
            ->where('showtime_id', (string) $showtime->getKey())
            ->where('booking_status', 'booked')
            ->whereIn('payment_status', ['pending', 'pending_gateway'])
            ->where('hold_expires_at', '>', now())
            ->get()
            ->map(fn (Booking $booking) => (string) $booking->getKey())
            ->all();
    }

    private function refreshHold(Booking $booking): void
    {
        if ($booking->hold_expires_at === null || $booking->hold_expires_at->lt(now())) {
            $booking->forceFill(['hold_expires_at' => now()->addMinutes(10)])->save();
        }
    }

    private function normalizeMissingHoldExpiry(Showtime $showtime): void
    {
        Booking::query()
            ->where('showtime_id', (string) $showtime->getKey())
            ->where('booking_status', 'booked')
            ->whereIn('payment_status', ['pending', 'pending_gateway'])
            ->whereNull('hold_expires_at')
            ->update(['hold_expires_at' => now()->addMinutes(10)]);
    }

    private function seatNumbersForBookings(array $bookingIds): array
    {
        if ($bookingIds === []) {
            return [];
        }

        $seatIds = BookingSeat::query()
            ->whereIn('booking_id', $bookingIds)
            ->pluck('seat_id')
            ->all();

        if ($seatIds === []) {
            return [];
        }

        return Seat::query()
            ->whereIn('_id', $seatIds)
            ->orderBy('seat_number')
            ->pluck('seat_number')
            ->all();
    }

    private function releaseExpiredHolds(): void
    {
        Booking::query()
            ->where('booking_status', 'booked')
            ->whereIn('payment_status', ['pending', 'pending_gateway'])
            ->whereNotNull('hold_expires_at')
            ->where('hold_expires_at', '<=', now())
            ->update(['booking_status' => 'expired']);
    }

    private function parseScheduleDateTime(string $showDate, string $showTime): Carbon
    {
        $time = preg_match('/\d{1,2}:\d{2}/', $showTime, $timeMatch) ? $timeMatch[0] : '19:00';
        $date = preg_match('/\d{1,2}\/\d{1,2}\/\d{4}/', $showDate, $fullDate)
            ? $fullDate[0]
            : (preg_match('/\d{1,2}\/\d{1,2}/', $showDate, $shortDate) ? $shortDate[0] . '/' . now()->year : now()->format('d/m/Y'));

        try {
            return Carbon::createFromFormat('d/m/Y H:i', $date . ' ' . $time);
        } catch (\Throwable) {
            return now()->setTimeFromTimeString($time);
        }
    }

    private function parseDate(?string $date): ?string
    {
        if ($date === null || trim($date) === '') {
            return null;
        }

        try {
            return Carbon::createFromFormat('d/m/Y', trim($date))->toDateString();
        } catch (\Throwable) {
            return null;
        }
    }
}

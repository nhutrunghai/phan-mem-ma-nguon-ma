@extends('layouts.admin')

@section('content')
@php
    $paymentLabels = [
        'pending' => 'Chờ thanh toán',
        'pending_gateway' => 'Chờ cổng thanh toán',
        'paid' => 'Đã thanh toán',
        'failed' => 'Thất bại',
        'refunded' => 'Đã hoàn tiền',
    ];
    $bookingLabels = [
        'booked' => 'Đã đặt',
        'cancelled' => 'Đã hủy',
        'checked_in' => 'Đã check-in',
    ];
@endphp
<section class="admin-panel">
    <div class="admin-panel__head">
        <h2>{{ $booking->qr_code }}</h2>
        <a class="btn btn-default" href="{{ route('admin.bookings.index') }}">Quay lại</a>
    </div>
    <div class="admin-panel__body">
        <div class="admin-form-grid">
            <div><strong>Phim:</strong> {{ $movie->title ?? 'Không có dữ liệu' }}</div>
            <div><strong>Phòng:</strong> {{ $room->name ?? 'Không có dữ liệu' }}</div>
            <div><strong>Suất:</strong> {{ optional($showtime?->start_time)->format('d/m/Y H:i') }}</div>
            <div><strong>Người dùng:</strong> {{ $user->email ?? $booking->user_id }}</div>
            <div><strong>Tổng tiền:</strong> {{ number_format((int) $booking->total_price) }}đ</div>
            <div><strong>Ghế:</strong>
                @foreach ($bookingSeats as $bookingSeat)
                    @php $seat = $seatsById[(string) $bookingSeat->seat_id] ?? null; @endphp
                    <span class="admin-badge">{{ $seat->seat_number ?? $bookingSeat->seat_id }}</span>
                @endforeach
            </div>
        </div>

        <hr>
        <form method="post" action="{{ route('admin.bookings.update', ['booking' => (string) $booking->getKey()]) }}" class="admin-actions">
            @csrf @method('PUT')
            <span class="admin-badge {{ $booking->payment_status === 'paid' ? 'ok' : 'warn' }}">Thanh toán: {{ $paymentLabels[$booking->payment_status] ?? $booking->payment_status }}</span>
            <select class="form-control" style="max-width:180px;" name="booking_status">
                @foreach (['booked', 'cancelled', 'checked_in'] as $item)
                    <option value="{{ $item }}" @selected($booking->booking_status === $item)>{{ $bookingLabels[$item] ?? $item }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary" type="submit">Cập nhật trạng thái</button>
        </form>
    </div>
</section>

<section class="admin-panel">
    <div class="admin-panel__head"><h2>Thanh toán</h2></div>
    <div class="admin-panel__body">
        @if ($payments->isEmpty())
            <div class="admin-empty">Chưa có bản ghi thanh toán.</div>
        @else
            <table class="table table-striped">
                <thead><tr><th>Cổng</th><th>Mã giao dịch</th><th>Số tiền</th><th>Trạng thái</th><th>Ngày</th></tr></thead>
                <tbody>
                @foreach ($payments as $payment)
                    <tr>
                        <td>{{ $payment->method }}</td>
                        <td>{{ $payment->transaction_code }}</td>
                        <td>{{ number_format((int) $payment->amount) }}đ</td>
                        <td>{{ $paymentLabels[$payment->status] ?? $payment->status }}</td>
                        <td>{{ optional($payment->payment_date)->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</section>
@endsection

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
    <div class="admin-panel__head"><h2>Danh sách đặt vé</h2></div>
    <div class="admin-panel__body">
        <form method="get" class="admin-actions" style="margin-bottom:16px;">
            <select class="form-control" style="max-width:220px;" name="status">
                <option value="">Tất cả trạng thái thanh toán</option>
                @foreach (['pending', 'pending_gateway', 'paid', 'failed', 'refunded'] as $item)
                    <option value="{{ $item }}" @selected($status === $item)>{{ $paymentLabels[$item] ?? $item }}</option>
                @endforeach
            </select>
            <button class="btn btn-default" type="submit">Lọc</button>
        </form>
        @if ($bookings->isEmpty())
            <div class="admin-empty">Chưa có đặt vé.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead><tr><th>Mã vé</th><th>Phim</th><th>Người dùng</th><th>Tổng tiền</th><th>Thanh toán</th><th>Đặt vé</th><th></th></tr></thead>
                    <tbody>
                    @foreach ($bookings as $booking)
                        @php
                            $movie = $moviesById[(string) $booking->showtime_id] ?? null;
                            $user = $usersById[(string) $booking->user_id] ?? null;
                        @endphp
                        <tr>
                            <td><strong>{{ $booking->qr_code }}</strong></td>
                            <td>{{ $movie->title ?? 'Không có dữ liệu' }}</td>
                            <td>{{ $user->email ?? $booking->user_id }}</td>
                            <td>{{ number_format((int) $booking->total_price) }}đ</td>
                            <td><span class="admin-badge {{ $booking->payment_status === 'paid' ? 'ok' : 'warn' }}">{{ $paymentLabels[$booking->payment_status] ?? $booking->payment_status }}</span></td>
                            <td>{{ $bookingLabels[$booking->booking_status] ?? $booking->booking_status }}</td>
                            <td><a class="btn btn-default btn-sm" href="{{ route('admin.bookings.show', ['booking' => (string) $booking->getKey()]) }}">Chi tiết</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $bookings->links() }}
        @endif
    </div>
</section>
@endsection

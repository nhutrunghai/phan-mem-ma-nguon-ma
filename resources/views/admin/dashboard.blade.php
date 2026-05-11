@extends('layouts.admin')

@section('content')
@php
    $paymentLabels = [
        'pending' => 'Chờ thanh toán',
        'pending_gateway' => 'Chờ cổng thanh toán',
        'paid' => 'Đã thanh toán',
        'success' => 'Thành công',
        'failed' => 'Thất bại',
        'refunded' => 'Đã hoàn tiền',
    ];
    $bookingLabels = [
        'booked' => 'Đã đặt',
        'cancelled' => 'Đã hủy',
        'checked_in' => 'Đã check-in',
        'expired' => 'Hết hạn giữ ghế',
    ];
@endphp
<div class="admin-stats">
    <div class="admin-stat"><strong>{{ $stats['movies'] }}</strong><span>Phim</span></div>
    <div class="admin-stat"><strong>{{ $stats['rooms'] }}</strong><span>Phòng chiếu</span></div>
    <div class="admin-stat"><strong>{{ $stats['showtimes'] }}</strong><span>Suất chiếu</span></div>
    <div class="admin-stat"><strong>{{ $stats['bookings'] }}</strong><span>Đơn còn hiệu lực</span></div>
    <div class="admin-stat"><strong>{{ $stats['paid_bookings'] }}</strong><span>Đơn đã thanh toán</span></div>
    <div class="admin-stat"><strong>{{ number_format($stats['paid_revenue']) }}đ</strong><span>Doanh thu xác nhận</span></div>
    <div class="admin-stat"><strong>{{ $stats['pending_bookings'] }}</strong><span>Đơn đang giữ ghế</span></div>
    <div class="admin-stat"><strong>{{ $stats['expired_bookings'] }}</strong><span>Đơn hết hạn</span></div>
    <div class="admin-stat"><strong>{{ $stats['users'] }}</strong><span>Người dùng</span></div>
</div>

<section class="admin-panel" style="margin-top:22px;">
    <div class="admin-panel__head">
        <h2>Đặt vé gần đây</h2>
        <a class="btn btn-primary btn-sm" href="{{ route('admin.bookings.index') }}"><i class="fa fa-list" aria-hidden="true"></i> Xem tất cả</a>
    </div>
    <div class="admin-panel__body">
        @if ($recentBookings->isEmpty())
            <div class="admin-empty">Chưa có đặt vé.</div>
        @else
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Mã vé</th>
                            <th>Phim</th>
                            <th>Tổng tiền</th>
                            <th>Thanh toán</th>
                            <th>Đặt vé</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentBookings as $booking)
                            @php
                                $movie = $moviesById[(string) $booking->showtime_id] ?? null;
                                $paymentClass = $booking->payment_status === 'paid'
                                    ? 'ok'
                                    : ($booking->payment_status === 'failed' || $booking->booking_status === 'expired' ? 'danger' : 'warn');
                            @endphp
                            <tr>
                                <td><strong>{{ $booking->qr_code }}</strong></td>
                                <td>{{ $movie->title ?? 'Không có dữ liệu' }}</td>
                                <td class="admin-nowrap">{{ number_format((int) $booking->total_price) }}đ</td>
                                <td><span class="admin-badge {{ $paymentClass }}">{{ $paymentLabels[$booking->payment_status] ?? $booking->payment_status }}</span></td>
                                <td><span class="admin-badge">{{ $bookingLabels[$booking->booking_status] ?? $booking->booking_status }}</span></td>
                                <td><a class="btn btn-default btn-sm" href="{{ route('admin.bookings.show', ['booking' => (string) $booking->getKey()]) }}">Chi tiết</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</section>
@endsection

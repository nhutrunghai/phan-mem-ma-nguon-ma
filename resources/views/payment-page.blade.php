@extends('layouts.app')

@php
    $showtime = $booking->showtime;
    $movie = $showtime?->movie;
    $room = $showtime?->room;
    $cinema = $room?->cinema;
    $seatNumbers = $booking->seats
        ->map(fn ($bookingSeat) => $bookingSeat->seat?->seat_number)
        ->filter()
        ->values()
        ->all();
@endphp

@section('content')
    <section class="page-placeholder member-page">
        <div class="container">
            <div class="member-panel">
                <div class="member-panel__head">
                    <h1>Thanh toán SePay</h1>
                    <span>Đơn vé {{ $booking->qr_code }}</span>
                </div>

                @if (session('status'))
                    <div style="margin-bottom:16px;">
                        <span class="status-ok">{{ session('status') }}</span>
                    </div>
                @endif

                <div class="member-grid">
                    <div class="member-field">
                        <label>Mã vé</label>
                        <input type="text" class="form-control" value="{{ $booking->qr_code }}" readonly>
                    </div>
                    <div class="member-field">
                        <label>Phim</label>
                        <input type="text" class="form-control" value="{{ $movie?->title ?? 'Beta Cinemas' }}" readonly>
                    </div>
                    <div class="member-field">
                        <label>Rạp</label>
                        <input type="text" class="form-control" value="{{ $cinema?->name ?? '' }}" readonly>
                    </div>
                    <div class="member-field">
                        <label>Ngày giờ</label>
                        <input type="text" class="form-control" value="{{ $showtime?->start_time?->format('d/m/Y H:i') ?? '' }}" readonly>
                    </div>
                    <div class="member-field">
                        <label>Ghế</label>
                        <input type="text" class="form-control" value="{{ implode(', ', $seatNumbers) }}" readonly>
                    </div>
                    <div class="member-field">
                        <label>Tổng tiền</label>
                        <input type="text" class="form-control" value="{{ number_format((int) $booking->total_price) }}đ" readonly>
                    </div>
                </div>

                <div class="member-panel" style="margin-top:18px;">
                    <div class="member-panel__head">
                        <h1>Quét QR chuyển khoản</h1>
                        <span>{{ $sepayInfo['order_code'] ?? '' }}</span>
                    </div>

                    @if ($sepayConfigured)
                        <div class="member-grid">
                            <div class="member-field member-field--full" style="text-align:center;">
                                <img
                                    src="{{ $sepayInfo['qr_code_url'] ?? '' }}"
                                    alt="QR SePay"
                                    style="width:280px;max-width:100%;background:#fff;border:1px solid #e5edf5;border-radius:8px;padding:10px;">
                            </div>
                            <div class="member-field">
                                <label>Ngân hàng</label>
                                <input type="text" class="form-control" value="{{ $sepayInfo['bank_short_name'] ?? '' }}" readonly>
                            </div>
                            <div class="member-field">
                                <label>Số tài khoản</label>
                                <input type="text" class="form-control" value="{{ $sepayInfo['account_number'] ?? '' }}" readonly>
                            </div>
                            <div class="member-field">
                                <label>Chủ tài khoản</label>
                                <input type="text" class="form-control" value="{{ $sepayInfo['account_holder_name'] ?? '' }}" readonly>
                            </div>
                            <div class="member-field">
                                <label>Số tiền</label>
                                <input type="text" class="form-control" value="{{ number_format((int) ($sepayInfo['amount'] ?? 0)) }}đ" readonly>
                            </div>
                            <div class="member-field member-field--full">
                                <label>Nội dung chuyển khoản</label>
                                <input type="text" class="form-control" value="{{ $sepayInfo['transfer_content'] ?? '' }}" readonly>
                            </div>
                        </div>
                        <p style="margin-top:12px;color:#5c6b7a;">
                            Sau khi SePay gửi webhook, đơn vé sẽ tự chuyển sang trạng thái đã thanh toán.
                        </p>
                    @else
                        <p style="color:#d44817;font-weight:700;">
                            SePay chưa được cấu hình đủ trong .env. Cần có ngân hàng, số tài khoản và tên chủ tài khoản.
                        </p>
                    @endif
                </div>

                <div class="member-actions">
                    <form method="post" action="{{ route('bookings.payment.confirm', ['booking' => (string) $booking->getKey()]) }}">
                        @csrf
                        <button type="submit" name="method" value="sepay" class="btn-mua-ve">Tôi đã chuyển khoản SePay</button>
                        @if ($vnpayUrl)
                            <button type="submit" name="method" value="vnpay" class="btn-mua-ve">Thanh toán qua VNPay</button>
                        @endif
                    </form>
                    <a class="btn-mua-ve" href="{{ route('account.demo', ['tab' => 'history']) }}">Xem lịch sử</a>
                </div>
            </div>
        </div>
    </section>
@endsection

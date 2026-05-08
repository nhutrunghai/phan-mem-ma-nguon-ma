@extends('layouts.app')

@section('content')
    <section class="page-placeholder member-page">
        <div class="container">
            <div class="member-panel">
                <div class="member-panel__head">
                    <h1>Thanh toán SePay</h1>
                    <span>Đơn vé {{ $booking['code'] ?? '' }}</span>
                </div>

                @if (session('status'))
                    <div style="margin-bottom:16px;">
                        <span class="status-ok">{{ session('status') }}</span>
                    </div>
                @endif

                <div class="member-grid">
                    <div class="member-field">
                        <label>Mã vé</label>
                        <input type="text" class="form-control" value="{{ $booking['code'] ?? '' }}" readonly>
                    </div>
                    <div class="member-field">
                        <label>Phim</label>
                        <input type="text" class="form-control" value="{{ $booking['movie_title'] ?? '' }}" readonly>
                    </div>
                    <div class="member-field">
                        <label>Rạp</label>
                        <input type="text" class="form-control" value="{{ $booking['cinema'] ?? '' }}" readonly>
                    </div>
                    <div class="member-field">
                        <label>Ngày giờ</label>
                        <input type="text" class="form-control" value="{{ ($booking['show_date'] ?? '') . ' ' . ($booking['show_time'] ?? '') }}" readonly>
                    </div>
                    <div class="member-field">
                        <label>Ghế</label>
                        <input type="text" class="form-control" value="{{ implode(', ', $booking['seats'] ?? []) }}" readonly>
                    </div>
                    <div class="member-field">
                        <label>Tổng tiền</label>
                        <input type="text" class="form-control" value="{{ number_format((int) ($booking['total'] ?? 0)) }}đ" readonly>
                    </div>
                </div>

                <div class="member-actions">
                    <form method="post" action="{{ route('booking.demo.payment.confirm', ['code' => $booking['code'] ?? '']) }}">
                        @csrf
                        <button type="submit" class="btn-mua-ve">Xác nhận thanh toán SePay</button>
                    </form>
                    <a class="btn-mua-ve" href="{{ route('account.demo', ['tab' => 'history']) }}">Xem lịch sử</a>
                </div>
            </div>
        </div>
    </section>
@endsection

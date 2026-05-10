@extends('layouts.app')

@php
    $demoUser = session('demo_user', [
        'name' => 'Beta Member',
        'email' => 'member@betacinemas.vn',
    ]);

    $tabs = [
        'profile' => 'Thông tin tài khoản',
        'history' => 'Lịch sử giao dịch',
        'points' => 'Điểm Beta',
        'password' => 'Đổi mật khẩu',
    ];
    $bookings = $bookings ?? session('demo_bookings', []);
@endphp

@section('content')
    <section class="page-placeholder member-page">
        <div class="container">
            <div class="member-layout">
                <aside class="member-sidebar">
                    <div class="member-card">
                        <div class="member-avatar">
                            {{ strtoupper(mb_substr($demoUser['name'], 0, 1)) }}
                        </div>
                        <div class="member-summary">
                            <h2>{{ $demoUser['name'] }}</h2>
                            <p>{{ $demoUser['email'] }}</p>
                        </div>
                    </div>

                    <ul class="member-menu">
                        @foreach ($tabs as $key => $label)
                            <li class="{{ $activeTab === $key ? 'is-active' : '' }}">
                                <a href="{{ route('account.demo', ['tab' => $key]) }}">{{ $label }}</a>
                            </li>
                        @endforeach
                    </ul>

                    <a class="member-logout" href="{{ route('auth.demo.logout') }}">Đăng xuất</a>
                </aside>

                <div class="member-content">
                    @if (session('status'))
                        <div class="member-panel" style="margin-bottom:16px;">
                            <span class="status-ok">{{ session('status') }}</span>
                        </div>
                    @endif
                    @if ($activeTab === 'profile')
                        <div class="member-panel">
                            <div class="member-panel__head">
                                <h1>Thông tin tài khoản</h1>
                                <span>Đã đăng nhập thành công</span>
                            </div>
                            <div class="member-grid">
                                <div class="member-field member-field--full">
                                    <label>Ảnh đại diện</label>
                                    <div class="member-upload">
                                        <div class="member-upload__preview">
                                            {{ strtoupper(mb_substr($demoUser['name'], 0, 1)) }}
                                        </div>
                                        <div class="member-upload__controls">
                                            <label class="member-upload__button" for="profileAvatar">
                                                Chọn ảnh
                                            </label>
                                            <input id="profileAvatar" type="file" class="member-upload__input" accept="image/png,image/jpeg,image/webp">
                                            <p>Hỗ trợ JPG, PNG, WEBP. Đây là giao diện upload tạm thời.</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="member-field">
                                    <label>Họ tên</label>
                                    <input type="text" class="form-control" value="{{ $demoUser['name'] }}">
                                </div>
                                <div class="member-field">
                                    <label>Email</label>
                                    <input type="text" class="form-control" value="{{ $demoUser['email'] }}">
                                </div>
                                <div class="member-field">
                                    <label>Số điện thoại</label>
                                    <input type="text" class="form-control" value="0987 654 321">
                                </div>
                                <div class="member-field">
                                    <label>Ngày sinh</label>
                                    <input type="text" class="form-control" value="01/01/2000">
                                </div>
                                <div class="member-field">
                                    <label>Giới tính</label>
                                    <input type="text" class="form-control" value="Nam">
                                </div>
                                <div class="member-field">
                                    <label>CMND / CCCD</label>
                                    <input type="text" class="form-control" value="012345678901">
                                </div>
                                <div class="member-field">
                                    <label>Tỉnh / Thành phố</label>
                                    <select class="form-control">
                                        <option>Thái Nguyên</option>
                                        <option>Hà Nội</option>
                                        <option>TP. Hồ Chí Minh</option>
                                        <option>Thanh Hóa</option>
                                    </select>
                                </div>
                                <div class="member-field">
                                    <label>Quận / Huyện</label>
                                    <select class="form-control">
                                        <option>TP. Thái Nguyên</option>
                                        <option>Ba Đình</option>
                                        <option>Cầu Giấy</option>
                                        <option>Quận 1</option>
                                    </select>
                                </div>
                                <div class="member-field member-field--full">
                                    <label>Địa chỉ</label>
                                    <input type="text" class="form-control" value="Số 595 đường Giải Phóng, Phường Tương Mai">
                                </div>
                                <div class="member-field">
                                    <label>Rạp yêu thích</label>
                                    <input type="text" class="form-control" value="Beta Thái Nguyên">
                                </div>
                                <div class="member-field">
                                    <label>Mã thành viên</label>
                                    <input type="text" class="form-control" value="BETA-000128" readonly>
                                </div>
                            </div>
                            <div class="member-actions">
                                <button type="button" class="btn-mua-ve">Cập nhật thông tin</button>
                            </div>
                        </div>
                    @endif

                    @if ($activeTab === 'history')
                        <div class="member-panel">
                            <div class="member-panel__head">
                                <h1>Lịch sử giao dịch</h1>
                                <span>Danh sách vé đã giữ trong phiên này</span>
                            </div>
                            @if (empty($bookings))
                                <p>Bạn chưa có giao dịch nào.</p>
                            @else
                                <div class="member-table">
                                    <div class="member-table__row member-table__row--head member-table__row--history">
                                        <span>Mã vé</span>
                                        <span>Phim</span>
                                        <span>Phòng</span>
                                        <span>Ngày chiếu</span>
                                        <span>Trạng thái</span>
                                        <span>Thanh toán</span>
                                    </div>
                                    @foreach ($bookings as $booking)
                                        @php
                                            $status = (string) ($booking['status'] ?? '');
                                            $isPendingPayment = ($booking['is_pending_payment'] ?? false)
                                                || str_contains($status, 'Chờ thanh toán');
                                            $paymentUrl = $booking['payment_url'] ?? null;
                                        @endphp
                                        <div class="member-table__row member-table__row--history">
                                            <span>{{ $booking['code'] ?? '' }}</span>
                                            <span>{{ $booking['movie_title'] ?? '' }}<br>{{ implode(', ', $booking['seats'] ?? []) }}</span>
                                            <span>{{ $booking['room'] ?? '' }}</span>
                                            <span>{{ ($booking['show_date'] ?? '') . ' ' . ($booking['show_time'] ?? '') }}</span>
                                            <span class="{{ $isPendingPayment ? 'status-warn' : 'status-ok' }}">{{ $booking['status'] ?? '' }}</span>
                                            <span class="member-table__payment">
                                                @if ($isPendingPayment && $paymentUrl)
                                                    <a class="btn-mua-ve" style="padding:8px 12px;font-size:12px;" href="{{ $paymentUrl }}">Thanh toán tiếp</a>
                                                @else
                                                    <span class="status-ok">Hoàn tất</span>
                                                @endif
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endif

                    @if ($activeTab === 'points')
                        <div class="member-panel">
                            <div class="member-panel__head">
                                <h1>Điểm Beta</h1>
                                <span>Thông tin khách hàng thân thiết</span>
                            </div>
                            <div class="points-hero">
                                <div>
                                    <strong>1,250</strong>
                                    <p>Điểm hiện có</p>
                                </div>
                                <div>
                                    <strong>Bạc</strong>
                                    <p>Hạng thành viên</p>
                                </div>
                                <div>
                                    <strong>250</strong>
                                    <p>Điểm để lên hạng Vàng</p>
                                </div>
                            </div>
                            <div class="member-table">
                                <div class="member-table__row member-table__row--head">
                                    <span>Ngày</span>
                                    <span>Nội dung</span>
                                    <span>Điểm</span>
                                </div>
                                <div class="member-table__row">
                                    <span>29/04/2026</span>
                                    <span>Mua vé online</span>
                                    <span class="status-ok">+120</span>
                                </div>
                                <div class="member-table__row">
                                    <span>20/04/2026</span>
                                    <span>Đổi combo bắp nước</span>
                                    <span class="status-warn">-80</span>
                                </div>
                                <div class="member-table__row">
                                    <span>12/04/2026</span>
                                    <span>Ưu đãi thành viên</span>
                                    <span class="status-ok">+50</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($activeTab === 'password')
                        <div class="member-panel">
                            <div class="member-panel__head">
                                <h1>Đổi mật khẩu</h1>
                                <span>Form giao diện mẫu cho thành viên</span>
                            </div>
                            <div class="member-grid member-grid--single">
                                <div class="member-field">
                                    <label>Mật khẩu hiện tại</label>
                                    <input type="password" class="form-control" placeholder="Mật khẩu hiện tại">
                                </div>
                                <div class="member-field">
                                    <label>Mật khẩu mới</label>
                                    <input type="password" class="form-control" placeholder="Mật khẩu mới">
                                </div>
                                <div class="member-field">
                                    <label>Xác nhận mật khẩu mới</label>
                                    <input type="password" class="form-control" placeholder="Xác nhận mật khẩu mới">
                                </div>
                            </div>
                            <div class="member-actions">
                                <button type="button" class="btn-mua-ve">Cập nhật mật khẩu</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection

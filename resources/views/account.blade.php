@extends('layouts.app')

@php
    $demoUser = session('demo_user', []);
    $profile = array_merge([
        'name' => '',
        'email' => '',
        'phone' => '',
        'birthday' => '',
        'gender' => '',
        'identity_number' => '',
        'province' => '',
        'district' => '',
        'address' => '',
        'favorite_cinema' => '',
        'member_code' => '',
    ], is_array($demoUser) ? $demoUser : []);

    $genderLabels = [
        'male' => 'Nam',
        'female' => 'Nữ',
        'other' => 'Khác',
    ];

    $tabs = [
        'profile' => 'Thông tin tài khoản',
        'history' => 'Lịch sử giao dịch',
        'points' => 'Điểm Beta',
        'password' => 'Đổi mật khẩu',
    ];

    $bookings = $bookings ?? session('demo_bookings', []);
    $emptyText = 'Chưa cập nhật';
    $avatarLetter = strtoupper(mb_substr((string) ($profile['name'] ?: 'B'), 0, 1));
@endphp

@section('content')
    <section class="page-placeholder member-page">
        <div class="container">
            <div class="member-layout">
                <aside class="member-sidebar">
                    <div class="member-card">
                        <div class="member-avatar">{{ $avatarLetter }}</div>
                        <div class="member-summary">
                            <h2>{{ $profile['name'] ?: $emptyText }}</h2>
                            <p>{{ $profile['email'] ?: $emptyText }}</p>
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
                        <form class="member-panel" method="post" action="{{ route('account.demo.update') }}">
                            @csrf
                            <div class="member-panel__head">
                                <h1>Thông tin tài khoản</h1>
                                <span>Dữ liệu lấy từ thông tin bạn đã nhập</span>
                            </div>
                            @if ($errors->any())
                                <div class="status-warn" style="margin:0 0 16px;">
                                    {{ $errors->first() }}
                                </div>
                            @endif
                            <div class="member-grid">
                                <div class="member-field member-field--full">
                                    <label>Ảnh đại diện</label>
                                    <div class="member-upload">
                                        <div class="member-upload__preview">{{ $avatarLetter }}</div>
                                        <div class="member-upload__controls">
                                            <label class="member-upload__button" for="profileAvatar">Chọn ảnh</label>
                                            <input id="profileAvatar" type="file" class="member-upload__input" accept="image/png,image/jpeg,image/webp">
                                            <p>Chưa lưu ảnh đại diện vào hệ thống.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="member-field">
                                    <label>Họ tên</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $profile['name']) }}" placeholder="{{ $emptyText }}" required>
                                </div>
                                <div class="member-field">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ old('email', $profile['email']) }}" placeholder="{{ $emptyText }}" required>
                                </div>
                                <div class="member-field">
                                    <label>Số điện thoại</label>
                                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile['phone']) }}" placeholder="{{ $emptyText }}">
                                </div>
                                <div class="member-field">
                                    <label>Ngày sinh</label>
                                    <input type="text" name="birthday" class="form-control" value="{{ old('birthday', $profile['birthday']) }}" placeholder="{{ $emptyText }}">
                                </div>
                                <div class="member-field">
                                    <label>Giới tính</label>
                                    <select name="gender" class="form-control">
                                        <option value="">Chưa cập nhật</option>
                                        @foreach ($genderLabels as $value => $label)
                                            <option value="{{ $value }}" @selected(old('gender', $profile['gender']) === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="member-field">
                                    <label>CMND / CCCD</label>
                                    <input type="text" name="identity_number" class="form-control" value="{{ old('identity_number', $profile['identity_number']) }}" placeholder="{{ $emptyText }}">
                                </div>
                                <div class="member-field">
                                    <label>Tỉnh / Thành phố</label>
                                    <input type="text" name="province" class="form-control" value="{{ old('province', $profile['province']) }}" placeholder="{{ $emptyText }}">
                                </div>
                                <div class="member-field">
                                    <label>Quận / Huyện</label>
                                    <input type="text" name="district" class="form-control" value="{{ old('district', $profile['district']) }}" placeholder="{{ $emptyText }}">
                                </div>
                                <div class="member-field member-field--full">
                                    <label>Địa chỉ</label>
                                    <input type="text" name="address" class="form-control" value="{{ old('address', $profile['address']) }}" placeholder="{{ $emptyText }}">
                                </div>
                                <div class="member-field">
                                    <label>Rạp yêu thích</label>
                                    <input type="text" name="favorite_cinema" class="form-control" value="{{ old('favorite_cinema', $profile['favorite_cinema']) }}" placeholder="{{ $emptyText }}">
                                </div>
                                <div class="member-field">
                                    <label>Mã thành viên</label>
                                    <input type="text" class="form-control" value="{{ $profile['member_code'] }}" placeholder="{{ $emptyText }}" readonly>
                                </div>
                            </div>
                            <div class="member-actions">
                                <button type="submit" class="btn-mua-ve">Cập nhật thông tin</button>
                            </div>
                        </form>
                    @endif

                    @if ($activeTab === 'history')
                        <div class="member-panel">
                            <div class="member-panel__head">
                                <h1>Lịch sử giao dịch</h1>
                                <span>Danh sách vé của tài khoản này</span>
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
                                            $isExpired = ($booking['is_expired'] ?? false) || str_contains($status, 'Hết hạn');
                                            $isPendingPayment = ($booking['is_pending_payment'] ?? false) || str_contains($status, 'Chờ thanh toán');
                                            $paymentUrl = $booking['payment_url'] ?? null;
                                        @endphp
                                        <div class="member-table__row member-table__row--history">
                                            <span>{{ $booking['code'] ?? '' }}</span>
                                            <span>{{ $booking['movie_title'] ?? '' }}<br>{{ implode(', ', $booking['seats'] ?? []) }}</span>
                                            <span>{{ $booking['room'] ?? '' }}</span>
                                            <span>{{ ($booking['show_date'] ?? '') . ' ' . ($booking['show_time'] ?? '') }}</span>
                                            <span class="{{ $isExpired || $isPendingPayment ? 'status-warn' : 'status-ok' }}">{{ $booking['status'] ?? '' }}</span>
                                            <span class="member-table__payment">
                                                @if ($isPendingPayment && $paymentUrl)
                                                    <a class="btn-mua-ve" style="padding:8px 12px;font-size:12px;" href="{{ $paymentUrl }}">Thanh toán tiếp</a>
                                                @elseif ($isExpired)
                                                    <span class="status-warn">Hết hạn</span>
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
                                <span>Chưa nối dữ liệu điểm thành viên</span>
                            </div>
                            <div class="points-hero">
                                <div>
                                    <strong>0</strong>
                                    <p>Điểm hiện có</p>
                                </div>
                                <div>
                                    <strong>{{ $emptyText }}</strong>
                                    <p>Hạng thành viên</p>
                                </div>
                                <div>
                                    <strong>0</strong>
                                    <p>Điểm sắp hết hạn</p>
                                </div>
                            </div>
                            <p>Chưa có lịch sử điểm.</p>
                        </div>
                    @endif

                    @if ($activeTab === 'password')
                        <div class="member-panel">
                            <div class="member-panel__head">
                                <h1>Đổi mật khẩu</h1>
                                <span>Chưa nối chức năng đổi mật khẩu</span>
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

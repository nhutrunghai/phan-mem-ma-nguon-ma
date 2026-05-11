@extends('layouts.app')

@section('content')
    <section class="member-shell">
        <div class="member-card" style="max-width:560px;margin:0 auto;">
            <div class="member-panel">
                <div class="member-panel__head">
                    <h1>Đặt lại mật khẩu</h1>
                    <p>Nhập mã OTP đã gửi về email và mật khẩu mới.</p>
                </div>

                @if (session('status'))
                    <div class="payment-status" style="margin-bottom:16px;">
                        <span class="status-ok">{{ session('status') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="status-warn" style="margin-bottom:16px;">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="post" action="{{ route('password.reset.update') }}">
                    @csrf
                    <div class="member-grid" style="grid-template-columns:1fr;">
                        <div class="member-field">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', $email ?? '') }}" required>
                        </div>
                        <div class="member-field">
                            <label>Mã OTP</label>
                            <input type="text" name="otp" class="form-control" inputmode="numeric" autocomplete="one-time-code" maxlength="6" required>
                        </div>
                        <div class="member-field">
                            <label>Mật khẩu mới</label>
                            <input type="password" name="password" class="form-control" autocomplete="new-password" required>
                        </div>
                        <div class="member-field">
                            <label>Nhập lại mật khẩu mới</label>
                            <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password" required>
                        </div>
                    </div>

                    <div class="member-actions">
                        <button type="submit" class="btn-mua-ve">Đổi mật khẩu</button>
                        <a class="btn-mua-ve btn-mua-ve--ghost" href="{{ route('auth.login.form') }}#login">Quay lại đăng nhập</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection

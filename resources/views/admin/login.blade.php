<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng nhập quản trị - Beta Cinemas</title>
    <style>
        :root {
            --admin-primary: #005198;
            --admin-primary-dark: #063f73;
            --admin-ink: #172433;
            --admin-muted: #667789;
            --admin-border: #d8e2ed;
            --admin-panel: #ffffff;
            --admin-danger-bg: #fff3e0;
            --admin-danger-border: #f3d19a;
            --admin-danger-text: #8a5300;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            background:
                linear-gradient(135deg, rgba(0, 81, 152, .12), rgba(0, 81, 152, 0) 42%),
                linear-gradient(180deg, #f7fafd 0%, #eef3f8 100%);
            color: var(--admin-ink);
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-weight: 400;
            line-height: 1.5;
        }

        .admin-login-page {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 32px 18px;
        }

        .admin-login-shell {
            width: min(920px, 100%);
            display: grid;
            grid-template-columns: minmax(0, .95fr) minmax(360px, 1fr);
            overflow: hidden;
            background: var(--admin-panel);
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            box-shadow: 0 24px 70px rgba(16, 35, 56, .14);
        }

        .admin-login-hero {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 42px;
            min-height: 520px;
            padding: 38px;
            background:
                linear-gradient(160deg, rgba(0, 81, 152, .92), rgba(6, 63, 115, .98)),
                url("{{ asset('web-home/assets/img/sidebar-banner.jpg') }}") center/cover;
            color: #fff;
        }

        .admin-login-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 20px;
            font-weight: 600;
        }

        .admin-login-mark {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: #fff;
            color: var(--admin-primary);
            font-weight: 600;
            letter-spacing: 0;
        }

        .admin-login-hero h1 {
            max-width: 360px;
            margin: 0 0 12px;
            font-size: 34px;
            line-height: 1.15;
            font-weight: 600;
            letter-spacing: 0;
        }

        .admin-login-hero p {
            max-width: 340px;
            margin: 0;
            color: rgba(255, 255, 255, .82);
            font-size: 15px;
        }

        .admin-login-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .admin-login-meta span {
            display: inline-flex;
            align-items: center;
            min-height: 30px;
            padding: 5px 10px;
            border: 1px solid rgba(255, 255, 255, .24);
            border-radius: 8px;
            background: rgba(255, 255, 255, .1);
            color: rgba(255, 255, 255, .88);
            font-size: 12px;
            font-weight: 500;
        }

        .admin-login {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 44px;
        }

        .admin-login h1 {
            margin: 0 0 8px;
            color: var(--admin-ink);
            font-size: 28px;
            line-height: 1.2;
            font-weight: 600;
            letter-spacing: 0;
        }

        .admin-login p {
            margin: 0 0 28px;
            color: var(--admin-muted);
            font-size: 14px;
        }

        .admin-login label {
            display: block;
            margin: 16px 0 7px;
            color: #2f4054;
            font-size: 13px;
            font-weight: 500;
        }

        .admin-login input {
            width: 100%;
            height: 46px;
            border: 1px solid #c9d5e2;
            border-radius: 8px;
            background: #fbfdff;
            color: var(--admin-ink);
            padding: 0 14px;
            font: inherit;
            outline: none;
            transition: border-color .16s ease, box-shadow .16s ease, background .16s ease;
        }

        .admin-login input:focus {
            border-color: var(--admin-primary);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(0, 81, 152, .12);
        }

        .admin-login button {
            width: 100%;
            min-height: 48px;
            margin-top: 20px;
            border: 0;
            border-radius: 8px;
            background: var(--admin-primary);
            color: #fff;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            box-shadow: 0 12px 26px rgba(0, 81, 152, .24);
            transition: transform .16s ease, box-shadow .16s ease, background .16s ease;
        }

        .admin-login button:hover,
        .admin-login button:focus {
            background: var(--admin-primary-dark);
            box-shadow: 0 14px 30px rgba(0, 81, 152, .3);
            transform: translateY(-1px);
        }

        .admin-login button:active { transform: translateY(0); }

        .admin-alert {
            margin: 0 0 14px;
            padding: 11px 12px;
            background: var(--admin-danger-bg);
            color: var(--admin-danger-text);
            border: 1px solid var(--admin-danger-border);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 500;
        }

        .admin-login-footer {
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid #edf1f6;
            color: var(--admin-muted);
            font-size: 12px;
        }

        @media (max-width: 760px) {
            .admin-login-page {
                align-items: start;
                padding: 18px;
            }

            .admin-login-shell { grid-template-columns: 1fr; }

            .admin-login-hero {
                min-height: auto;
                padding: 28px;
                gap: 28px;
            }

            .admin-login-hero h1 { font-size: 28px; }
            .admin-login { padding: 28px; }
        }

        @media (max-width: 420px) {
            .admin-login-page { padding: 12px; }

            .admin-login-hero,
            .admin-login { padding: 22px; }
        }
    </style>
</head>
<body>
    <main class="admin-login-page">
        @php
            $loginStatusMap = [
                'Vui long dang nhap admin.' => 'Vui lòng đăng nhập quản trị.',
                'Da dang xuat admin.' => 'Đã đăng xuất quản trị.',
            ];
            $loginErrorMap = [
                'Thong tin dang nhap admin khong dung.' => 'Thông tin đăng nhập quản trị không đúng.',
            ];
        @endphp
        <section class="admin-login-shell" aria-label="Đăng nhập quản trị">
            <div class="admin-login-hero">
                <div class="admin-login-brand">
                    <span class="admin-login-mark">B</span>
                    <span>Beta Cinemas</span>
                </div>
                <div>
                    <h1>Quản trị rạp chiếu phim</h1>
                    <p>Theo dõi lịch chiếu, phòng chiếu, đặt vé và nội dung phim trong một khu vực riêng.</p>
                </div>
                <div class="admin-login-meta" aria-label="Phân hệ quản trị">
                    <span>Phim</span>
                    <span>Suất chiếu</span>
                    <span>Đặt vé</span>
                </div>
            </div>

            <form class="admin-login" method="post" action="{{ route('admin.login.submit') }}">
                @csrf
                <h1>Đăng nhập quản trị</h1>
                <p>Sử dụng tài khoản quản trị để tiếp tục.</p>

                @if (session('status'))
                    <div class="admin-alert">{{ $loginStatusMap[session('status')] ?? session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="admin-alert">{{ $loginErrorMap[$errors->first()] ?? $errors->first() }}</div>
                @endif

                <label for="admin-email">Email</label>
                <input id="admin-email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>

                <label for="admin-password">Mật khẩu</label>
                <input id="admin-password" type="password" name="password" autocomplete="current-password" required>

                <button type="submit">Đăng nhập</button>

                <div class="admin-login-footer">
                    Bảng quản trị Beta Cinemas
                </div>
            </form>
        </section>
    </main>
</body>
</html>

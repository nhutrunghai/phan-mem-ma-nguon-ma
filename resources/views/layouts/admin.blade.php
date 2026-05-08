<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @php
        $adminTitleMap = [
            'Admin' => 'Quản trị',
            'Dashboard' => 'Tổng quan',
            'Quan ly phim' => 'Quản lý phim',
            'Them phim' => 'Thêm phim',
            'Sua phim' => 'Sửa phim',
            'Quan ly rap' => 'Quản lý rạp',
            'Quan ly ghe' => 'Quản lý ghế',
            'Quan ly suat chieu' => 'Quản lý suất chiếu',
            'Quan ly booking' => 'Quản lý đặt vé',
            'Chi tiet booking' => 'Chi tiết đặt vé',
            'Quan ly nguoi dung' => 'Quản lý người dùng',
            'Cau hinh admin' => 'Cấu hình quản trị',
        ];
        $adminPageTitle = $adminTitleMap[$title ?? 'Admin'] ?? ($title ?? 'Quản trị');
        $adminStatusMap = [
            'Da them phim.' => 'Đã thêm phim.',
            'Da cap nhat phim.' => 'Đã cập nhật phim.',
            'Da xoa phim.' => 'Đã xóa phim.',
            'Da them rap.' => 'Đã thêm rạp.',
            'Da cap nhat rap.' => 'Đã cập nhật rạp.',
            'Da xoa rap.' => 'Đã xóa rạp.',
            'Da them phong chieu.' => 'Đã thêm phòng chiếu.',
            'Da cap nhat phong chieu.' => 'Đã cập nhật phòng chiếu.',
            'Da xoa phong chieu.' => 'Đã xóa phòng chiếu.',
            'Da cap nhat ghe.' => 'Đã cập nhật ghế.',
            'Da them suat chieu.' => 'Đã thêm suất chiếu.',
            'Da cap nhat suat chieu.' => 'Đã cập nhật suất chiếu.',
            'Da xoa suat chieu.' => 'Đã xóa suất chiếu.',
            'Da cap nhat booking.' => 'Đã cập nhật đặt vé.',
            'Da cap nhat nguoi dung.' => 'Đã cập nhật người dùng.',
            'Da luu cau hinh.' => 'Đã lưu cấu hình.',
        ];
    @endphp
    <title>{{ $adminPageTitle }} - Beta Cinemas</title>
    <link rel="stylesheet" href="{{ asset('beta-mirror/Assets/Common/Plugins/Bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('beta-mirror/Assets/Common/Plugins/font-awesome/css/font-awesome.min.css') }}">
    <style>
        :root {
            --admin-bg: #f5f7fb;
            --admin-surface: #ffffff;
            --admin-surface-2: #f9fbfd;
            --admin-border: #dbe4ee;
            --admin-border-soft: #edf1f6;
            --admin-text: #1d2b3a;
            --admin-muted: #657385;
            --admin-primary: #005198;
            --admin-primary-dark: #063f73;
            --admin-success: #16754b;
            --admin-warning: #996100;
            --admin-danger: #b83225;
        }

        body {
            margin: 0;
            background: var(--admin-bg);
            color: var(--admin-text);
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-weight: 400;
            font-size: 14px;
            line-height: 1.5;
        }

        .admin-shell {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 260px minmax(0, 1fr);
        }

        .admin-sidebar {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #102338;
            color: #fff;
            padding: 22px 0;
            border-right: 1px solid rgba(255, 255, 255, .08);
        }

        .admin-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 22px 22px;
            color: #fff;
            font-size: 20px;
            font-weight: 600;
            text-decoration: none;
        }

        .admin-brand:hover,
        .admin-brand:focus {
            color: #fff;
            text-decoration: none;
        }

        .admin-brand__mark {
            width: 34px;
            height: 34px;
            display: inline-grid;
            place-items: center;
            border-radius: 8px;
            background: var(--admin-primary);
        }

        .admin-nav {
            list-style: none;
            margin: 0;
            padding: 0 12px;
        }

        .admin-nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 11px 12px;
            border-radius: 8px;
            color: #c9d6e4;
            text-decoration: none;
            font-weight: 500;
        }

        .admin-nav a:hover,
        .admin-nav a.is-active {
            background: rgba(0, 81, 152, .95);
            color: #fff;
            text-decoration: none;
        }

        .admin-sidebar__footer {
            margin-top: auto;
            padding: 18px 12px 0;
        }

        .admin-sidebar__email {
            padding: 0 10px 10px;
            color: #9fb2c8;
            font-size: 12px;
            word-break: break-word;
        }

        .admin-logout-button {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 42px;
            padding: 11px 12px;
            border: 0;
            border-radius: 8px;
            background: rgba(255, 255, 255, .08);
            color: #fff;
            font: inherit;
            font-weight: 500;
            text-align: left;
            cursor: pointer;
        }

        .admin-logout-button:hover,
        .admin-logout-button:focus {
            background: rgba(184, 50, 37, .92);
            outline: none;
        }

        .admin-main { min-width: 0; }

        .admin-topbar {
            min-height: 70px;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 16px;
            padding: 0 28px;
            background: var(--admin-surface);
            border-bottom: 1px solid var(--admin-border);
        }

        .admin-title {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
            color: var(--admin-text);
        }

        .admin-user {
            color: var(--admin-muted);
            font-size: 13px;
            text-align: right;
        }

        .admin-content {
            padding: 28px;
        }

        .admin-panel,
        .admin-stat {
            background: var(--admin-surface);
            border: 1px solid var(--admin-border);
            border-radius: 8px;
            box-shadow: 0 6px 18px rgba(16, 35, 56, .05);
        }

        .admin-panel { margin-bottom: 22px; overflow: hidden; }

        .admin-panel__head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 18px 20px;
            border-bottom: 1px solid var(--admin-border-soft);
            background: var(--admin-surface-2);
        }

        .admin-panel__head h2,
        .admin-section-title {
            margin: 0;
            font-size: 17px;
            font-weight: 600;
        }

        .admin-panel__body { padding: 20px; }

        .admin-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .admin-stat {
            padding: 18px;
            min-height: 110px;
        }

        .admin-stat strong {
            display: block;
            color: var(--admin-primary);
            font-size: 28px;
            line-height: 1;
            letter-spacing: 0;
        }

        .admin-stat span {
            display: block;
            margin-top: 9px;
            color: var(--admin-muted);
            font-weight: 500;
        }

        .admin-actions,
        .admin-filter {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            align-items: center;
        }

        .admin-filter {
            margin-bottom: 16px;
            padding: 14px;
            background: var(--admin-surface-2);
            border: 1px solid var(--admin-border-soft);
            border-radius: 8px;
        }

        .admin-filter .form-control { width: auto; min-width: 180px; }

        .admin-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .admin-form-grid .full { grid-column: 1 / -1; }
        .admin-empty { padding: 32px 16px; text-align: center; color: var(--admin-muted); }
        .admin-inline-form { display: inline; }
        .admin-muted { color: var(--admin-muted); }
        .admin-nowrap { white-space: nowrap; }

        .admin-badge {
            display: inline-flex;
            align-items: center;
            min-height: 24px;
            padding: 3px 9px;
            border-radius: 999px;
            background: #eef3f8;
            color: #3f5266;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }

        .admin-badge.ok { background: #e8f6ee; color: var(--admin-success); }
        .admin-badge.warn { background: #fff5df; color: var(--admin-warning); }
        .admin-badge.danger { background: #ffe9e6; color: var(--admin-danger); }

        .form-control {
            border-color: #cbd6e2;
            border-radius: 7px;
            box-shadow: none;
        }

        .form-control:focus {
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 3px rgba(0, 81, 152, .12);
        }

        label {
            color: #324458;
            font-weight: 600;
        }

        .btn {
            border-radius: 7px;
            font-weight: 600;
        }

        .btn-primary {
            background: var(--admin-primary);
            border-color: var(--admin-primary);
        }

        .btn-primary:hover,
        .btn-primary:focus {
            background: var(--admin-primary-dark);
            border-color: var(--admin-primary-dark);
        }

        .table {
            margin-bottom: 0;
        }

        .table > thead > tr > th {
            border-bottom: 1px solid var(--admin-border);
            color: #516276;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0;
            text-transform: none;
        }

        .table > tbody > tr > td {
            vertical-align: middle;
            border-top-color: var(--admin-border-soft);
        }

        .pagination { margin-bottom: 0; }

        @media (max-width: 1000px) {
            .admin-stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 760px) {
            .admin-shell { grid-template-columns: 1fr; }
            .admin-sidebar { min-height: auto; padding: 14px 0; }
            .admin-brand { padding-bottom: 12px; }
            .admin-nav { display: flex; overflow-x: auto; }
            .admin-nav a { white-space: nowrap; }
            .admin-sidebar__footer { margin-top: 12px; }
            .admin-topbar { padding: 16px; }
            .admin-content { padding: 16px; }
            .admin-stats,
            .admin-form-grid { grid-template-columns: 1fr; }
            .admin-form-grid .full { grid-column: auto; }
            .admin-filter .form-control,
            .admin-filter .btn { width: 100%; }
        }
    </style>
</head>
<body>
    @php
        $nav = [
            ['label' => 'Tổng quan', 'icon' => 'fa-dashboard', 'route' => 'admin.dashboard'],
            ['label' => 'Phim', 'icon' => 'fa-film', 'route' => 'admin.movies.index'],
            ['label' => 'Rạp & phòng', 'icon' => 'fa-building', 'route' => 'admin.cinemas.index'],
            ['label' => 'Suất chiếu', 'icon' => 'fa-calendar', 'route' => 'admin.showtimes.index'],
            ['label' => 'Đặt vé', 'icon' => 'fa-ticket', 'route' => 'admin.bookings.index'],
            ['label' => 'Người dùng', 'icon' => 'fa-users', 'route' => 'admin.users.index'],
        ];
    @endphp
    <div class="admin-shell">
        <aside class="admin-sidebar">
            <a class="admin-brand" href="{{ route('admin.dashboard') }}">
                <span class="admin-brand__mark"><i class="fa fa-bolt" aria-hidden="true"></i></span>
                <span>Beta Quản trị</span>
            </a>
            <ul class="admin-nav">
                @foreach ($nav as $item)
                    <li>
                        <a class="{{ request()->routeIs($item['route']) || request()->routeIs(str_replace('.index', '.*', $item['route'])) ? 'is-active' : '' }}" href="{{ route($item['route']) }}">
                            <i class="fa {{ $item['icon'] }}" aria-hidden="true"></i> {{ $item['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="admin-sidebar__footer">
                <div class="admin-sidebar__email">{{ session('admin_email', 'admin@example.com') }}</div>
                <form method="post" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="admin-logout-button" type="submit">
                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                        <span>Đăng xuất</span>
                    </button>
                </form>
            </div>
        </aside>
        <div class="admin-main">
            <header class="admin-topbar">
                <h1 class="admin-title">{{ $adminPageTitle }}</h1>
            </header>
            <main class="admin-content">
                @if (session('status'))
                    <div class="alert alert-success">{{ $adminStatusMap[session('status')] ?? session('status') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">{{ $errors->first() }}</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>

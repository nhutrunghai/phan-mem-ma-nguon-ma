<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Beta Cinemas' }}</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('web-home/assets/legacy-beta/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('web-home/assets/legacy-beta/favicon-16x16.png') }}">
    <link rel="stylesheet" href="{{ asset('web-home/assets/legacy-beta/Assets/Common/Plugins/Bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web-home/assets/legacy-beta/Assets/Common/Plugins/Bootstrap/css/bootstrap-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web-home/assets/legacy-beta/Assets/Common/Plugins/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web-home/assets/legacy-beta/Assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('web-home/assets/legacy-beta/Assets/global/css/components0e34.css') }}">
    <link rel="stylesheet" href="{{ asset('web-home/assets/legacy-beta/Assets/Common/css/style0e34.css') }}">
    <link rel="stylesheet" href="{{ asset('web-home/assets/legacy-beta/Assets/Common/css/css9bf4.css') }}">
    <link rel="stylesheet" href="{{ asset('web-home/assets/legacy-beta/Assets/global/css/plugins.css') }}">
    <link rel="stylesheet" href="{{ asset('web-home/assets/legacy-beta/Assets/frontend/pages/css/style-shop9bf4.css') }}">
    <link rel="stylesheet" href="{{ asset('web-home/assets/legacy-beta/Assets/frontend/layout/css/themes/blue9bf4.css') }}">
    <link rel="stylesheet" href="{{ asset('web-home/assets/legacy-beta/Assets/frontend/layout/css/custom71de.css') }}">
    <style>
        body.corporate {
            background: #fff;
        }

        .page-shell {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .page-main {
            flex: 1 0 auto;
            background: #fff;
            min-height: 520px;
        }

        .page-placeholder {
            padding: 48px 0 72px;
        }

        .page-placeholder .placeholder-card {
            max-width: 660px;
            margin: 0 auto;
            background: #fff;
            border: 1px solid #e5e5e5;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
        }

        .auth-panel {
            width: 50%;
            max-width: 585px;
            margin: 0 auto;
        }

        .auth-note {
            margin-top: 12px;
            color: #8a8a8a;
            font-size: 13px;
            text-align: center;
        }

        .modal-static-copy {
            text-align: justify;
            line-height: 1.7;
            color: #4d4d4d;
        }

        .account-state {
            overflow: hidden;
        }

        .account-state__header {
            padding: 32px 32px 18px;
            background: linear-gradient(135deg, #005198, #0d71c7);
            color: #fff;
        }

        .account-state__header h1 {
            margin: 14px 0 0;
            font-size: 28px;
            font-weight: 700;
            color: #fff;
        }

        .account-state__badge {
            display: inline-block;
            padding: 7px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.16);
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        .account-state__body {
            padding: 32px;
        }

        .account-state__body p {
            margin: 0;
            color: #5d6773;
            line-height: 1.8;
        }

        .account-state__actions {
            margin-top: 24px;
            text-align: center;
        }

        .member-page {
            padding-top: 36px;
        }

        .member-layout {
            display: grid;
            grid-template-columns: 260px minmax(0, 1fr);
            gap: 28px;
            align-items: start;
        }

        .member-sidebar,
        .member-panel {
            border: 1px solid #e5e5e5;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .member-card {
            padding: 24px 20px;
            background: linear-gradient(135deg, #005198, #1f7aca);
            color: #fff;
            text-align: center;
        }

        .member-avatar {
            width: 72px;
            height: 72px;
            margin: 0 auto 14px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.16);
            font-size: 30px;
            font-weight: 700;
        }

        .member-summary h2 {
            margin: 0 0 6px;
            color: #fff;
            font-size: 22px;
            font-weight: 700;
        }

        .member-summary p {
            margin: 0;
            color: rgba(255, 255, 255, 0.88);
            font-size: 14px;
        }

        .member-menu {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .member-menu li {
            border-top: 1px solid #edf1f5;
        }

        .member-menu li a {
            display: block;
            padding: 14px 18px;
            color: #2d3a48;
            text-decoration: none;
            font-weight: 600;
        }

        .member-menu li.is-active a {
            background: #eef6ff;
            color: #005198;
        }

        .member-logout {
            display: block;
            margin: 18px;
            padding: 12px 16px;
            border: 1px solid #dbe7f3;
            color: #005198;
            text-align: center;
            text-decoration: none;
            font-weight: 700;
        }

        .member-panel__head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: 22px 24px;
            border-bottom: 1px solid #edf1f5;
        }

        .member-panel__head h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 700;
            color: #243140;
        }

        .member-panel__head span {
            color: #6f7c89;
            font-size: 14px;
        }

        .member-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
            padding: 24px;
        }

        .member-grid--single {
            grid-template-columns: 1fr;
            max-width: 560px;
        }

        .member-field label {
            display: block;
            margin-bottom: 8px;
            color: #425163;
            font-size: 14px;
            font-weight: 700;
        }

        .member-field .form-control {
            height: 42px;
        }

        .member-field--full {
            grid-column: 1 / -1;
        }

        .member-upload {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 18px;
            border: 1px dashed #c9d7e4;
            background: #f8fbfe;
        }

        .member-upload__preview {
            width: 88px;
            height: 88px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #005198, #1f7aca);
            color: #fff;
            font-size: 34px;
            font-weight: 700;
            flex: 0 0 auto;
        }

        .member-upload__controls p {
            margin: 10px 0 0;
            color: #6f7c89;
            font-size: 13px;
        }

        .member-upload__button {
            display: inline-block;
            margin: 0;
            padding: 11px 16px;
            background: #005198;
            color: #fff;
            text-decoration: none;
            font-weight: 700;
            cursor: pointer;
        }

        .member-upload__input {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            border: 0;
        }

        .member-actions {
            padding: 0 24px 24px;
        }

        .payment-status {
            margin: 18px 24px 0;
            padding: 12px 14px;
            border: 1px solid #c9ead9;
            background: #f2fbf6;
            border-radius: 6px;
            line-height: 1.5;
        }

        .payment-transfer-card {
            margin: 0 24px 22px;
            border: 1px solid #edf1f5;
            box-shadow: none;
        }

        .payment-action-row {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .payment-action-form {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            margin: 0;
        }

        .payment-action-row .btn-mua-ve {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            white-space: nowrap;
        }

        .member-table {
            padding: 0 24px 24px;
        }

        .member-table__row {
            display: grid;
            grid-template-columns: 0.9fr 1.4fr 1.1fr 1.1fr 0.8fr;
            gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid #edf1f5;
            color: #405163;
            align-items: center;
        }

        .member-table__row--history {
            grid-template-columns: minmax(95px, .9fr) minmax(180px, 1.35fr) minmax(90px, .8fr) minmax(125px, 1fr) minmax(120px, .9fr) minmax(130px, .85fr);
        }

        .member-table__payment {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            min-width: 0;
        }

        .member-table__payment .btn-mua-ve {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 34px;
            white-space: nowrap;
        }

        .member-table__row--head {
            font-weight: 700;
            color: #223241;
        }

        .status-ok {
            color: #159957;
            font-weight: 700;
        }

        .status-warn {
            color: #d67a00;
            font-weight: 700;
        }

        .points-hero {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            padding: 24px;
        }

        .points-hero > div {
            padding: 22px 18px;
            border-radius: 14px;
            background: linear-gradient(135deg, #f4f8fc, #edf6ff);
            text-align: center;
        }

        .points-hero strong {
            display: block;
            font-size: 30px;
            line-height: 1;
            color: #005198;
        }

        .points-hero p {
            margin: 10px 0 0;
            color: #607080;
        }

        .placeholder-tabs {
            display: flex;
        }

        .placeholder-tab {
            width: 50%;
            padding: 14px 16px;
            text-align: center;
            font-size: 18px;
            font-weight: 700;
            text-transform: uppercase;
            border-bottom: 1px solid #ddd;
        }

        .placeholder-tab.is-active {
            background: #0d5a9d;
            color: #fff;
            border-bottom-color: #0d5a9d;
        }

        .placeholder-body {
            padding: 56px 40px 64px;
            text-align: center;
        }

        .placeholder-body h1 {
            margin: 0 0 16px;
            font-size: 28px;
            font-weight: 700;
            color: #2a2a2a;
            text-transform: uppercase;
        }

        .placeholder-body p {
            margin: 0;
            color: #666;
            font-size: 16px;
            line-height: 1.7;
        }

        @media (max-width: 767px) {
            .auth-panel {
                width: 100%;
                max-width: 100%;
            }

            .member-layout {
                grid-template-columns: 1fr;
            }

            .member-panel__head {
                flex-direction: column;
                align-items: flex-start;
            }

            .member-grid,
            .points-hero {
                grid-template-columns: 1fr;
            }

            .member-field--full {
                grid-column: auto;
            }

            .payment-transfer-card {
                margin-left: 16px;
                margin-right: 16px;
            }

            .payment-action-row,
            .payment-action-form {
                align-items: stretch;
                flex-direction: column;
            }

            .payment-action-row .btn-mua-ve {
                width: 100%;
            }

            .member-upload {
                flex-direction: column;
                align-items: flex-start;
            }

            .member-table {
                overflow-x: auto;
            }

            .member-table__row {
                min-width: 700px;
            }

            .member-table__row--history {
                min-width: 780px;
            }

            .page-placeholder {
                padding: 24px 12px 48px;
            }

            .placeholder-body {
                padding: 36px 20px 44px;
            }

            .placeholder-tab {
                font-size: 16px;
            }

            .placeholder-body h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body class="corporate">
    <div class="page-shell">
        @include('partials.header')

        <main class="page-main">
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    <script src="{{ asset('web-home/assets/legacy-beta/Assets/Common/Plugins/JQuery/jquery-1.11.2.min.js') }}"></script>
    <script src="{{ asset('web-home/assets/legacy-beta/Assets/Common/Plugins/Bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('web-home/assets/legacy-beta/Assets/Common/scripts/layout.js') }}"></script>
    <script>
        jQuery(function ($) {
            if (window.Layout && typeof window.Layout.init === 'function') {
                Layout.init();
                Layout.initFixHeaderWithPreHeader();
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

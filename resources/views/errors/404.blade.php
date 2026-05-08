<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Khong tim thay trang - Beta Cinemas</title>
    <link rel="stylesheet" href="{{ asset('web-home/assets/css/style.css') }}">
    <style>
        .error-page {
            min-height: 100vh;
            display: grid;
            grid-template-rows: auto 1fr;
            background: #f7f7f7;
        }
        .error-main {
            display: grid;
            place-items: center;
            padding: 48px 16px;
        }
        .error-panel {
            width: min(560px, 100%);
            text-align: center;
            background: #fff;
            border: 1px solid #e7eef7;
            padding: 32px 24px;
        }
        .error-panel h1 {
            margin: 0 0 10px;
            color: #0a5aa4;
            font-size: 32px;
            font-weight: 800;
        }
        .error-panel p {
            margin: 0 0 22px;
            color: #4b5563;
            font-size: 15px;
        }
        .error-actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .error-actions a {
            min-width: 130px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-weight: 800;
        }
        .error-actions .primary {
            background: #0a5aa4;
            color: #fff;
        }
        .error-actions .secondary {
            background: #fff;
            color: #0a5aa4;
            border: 1px solid #cbd5e1;
        }
    </style>
</head>
<body>
    <div class="error-page">
        <header class="header">
            <div class="container header-inner">
                <a class="brand" href="{{ url('/') }}">
                    <img class="brand-img" src="{{ asset('web-home/assets/img/beta-logo.png') }}" alt="Beta Cinemas">
                </a>
                <nav class="nav">
                    <a href="{{ route('schedule.index') }}">LICH CHIEU</a>
                    <a href="{{ route('movies.index') }}">PHIM</a>
                </nav>
            </div>
        </header>
        <main class="error-main">
            <section class="error-panel">
                <h1>Khong tim thay trang</h1>
                <p>Duong dan phim hoac noi dung nay khong ton tai.</p>
                <div class="error-actions">
                    <a class="primary" href="{{ route('movies.index') }}">Ve trang phim</a>
                    <a class="secondary" href="{{ url('/') }}">Ve trang chu</a>
                </div>
            </section>
        </main>
    </div>
</body>
</html>

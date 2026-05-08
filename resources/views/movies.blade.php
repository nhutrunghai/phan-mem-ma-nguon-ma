@php
    $demoUser = session('demo_user');
    $assetPath = static fn (string $path): string => asset('web-home/' . ltrim($path, '/'));
    $mediaPath = static fn (?string $path): string => str_starts_with((string) $path, 'http')
        ? (string) $path
        : asset('web-home/' . ltrim((string) $path, '/'));
@endphp
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ $assetPath('assets/css/style.css') }}">
    <style>
        .movie-filter {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 220px 120px 120px;
            gap: 10px;
            margin-bottom: 18px;
        }
        .movie-empty {
            grid-column: 1 / -1;
            padding: 28px;
            text-align: center;
            color: #005198;
            background: #f4f8fc;
            border-radius: 12px;
            font-weight: 700;
        }
        @media (max-width: 767px) {
            .movie-filter {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="page-shell phim-page-shell">
        <div class="topbar">
            <div class="container topbar-inner">
                <div class="topbar-spacer"></div>
                <div class="topbar-links">
                    @if ($demoUser)
                        <a href="{{ route('account.demo') }}">{{ $demoUser['name'] }}</a>
                        <span>|</span>
                        <a href="{{ route('auth.demo.logout') }}">Đăng xuất</a>
                    @else
                        @foreach ($topLinks as $index => $link)
                            <a href="{{ $link['href'] ?? '#' }}">{{ $link['label'] ?? '' }}</a>
                            @if ($index < count($topLinks) - 1)
                                <span>|</span>
                            @endif
                        @endforeach
                    @endif
                    <span class="flag">🇬🇧</span>
                </div>
            </div>
        </div>

        <header class="header">
            <div class="container header-inner">
                <a class="brand" href="{{ url('/') }}">
                    <img class="brand-img" src="{{ $assetPath('assets/img/beta-logo.png') }}" alt="Beta Cinemas">
                </a>
                <button class="location-pill" type="button">Beta Thái Nguyên <span class="caret">▾</span></button>
                <nav class="nav">
                    @foreach ($navItems as $item)
                        <a href="{{ $item['href'] ?? '#' }}">{{ $item['label'] ?? '' }}</a>
                    @endforeach
                </nav>
            </div>
        </header>

        <main class="phim-page">
            <section class="movies-section movies-section--phim">
                <div class="container">
                    <form class="movie-filter" method="get" action="{{ route('movies.index') }}" data-filter-form>
                        <input type="hidden" name="tab" value="{{ $activeTab }}">
                        <input type="text" name="q" class="form-control" placeholder="Tìm theo tên phim" value="{{ $search ?? '' }}">
                        <input type="text" name="genre" class="form-control" placeholder="Lọc theo thể loại" value="{{ $genre ?? '' }}">
                        <button type="submit" class="btn btn-primary">Lọc</button>
                        <a href="{{ route('movies.index', ['tab' => $activeTab]) }}" class="btn btn-default">Xóa lọc</a>
                    </form>
                    <div class="section-header section-header--phim" role="tablist" aria-label="Danh sách phim">
                        @foreach ($movieTabs as $tab)
                            <a class="tab{{ ($tab['id'] ?? '') === $activeTab ? ' active' : '' }}" href="{{ route('movies.index', ['tab' => $tab['id'] ?? '', 'q' => $search ?? '', 'genre' => $genre ?? '']) }}">
                                {{ $tab['label'] ?? '' }}
                            </a>
                        @endforeach
                    </div>

                    <div class="movie-grid phim-grid">
                        @forelse ($movies as $movie)
                            <article class="movie-card movie-card--phim">
                                <a class="poster-wrap" href="{{ $movie['buyUrl'] ?? '#' }}">
                                    <img src="{{ $mediaPath($movie['poster'] ?? '') }}" alt="{{ $movie['title'] ?? '' }}">
                                    @if (!empty($movie['tag']))
                                        <span class="movie-tag">{{ $movie['tag'] }}</span>
                                    @endif
                                    @if (!empty($movie['label']))
                                        <span class="age-badge">{{ $movie['label'] }}</span>
                                    @endif
                                </a>
                                <h3><a href="{{ $movie['buyUrl'] ?? '#' }}">{{ $movie['title'] ?? '' }}</a></h3>
                                <p><strong>Thể loại:</strong> {{ $movie['genre'] ?? '' }}</p>
                                <p><strong>Thời lượng:</strong> {{ $movie['duration'] ?? '' }} phút</p>
                                <a class="buy-ticket" href="{{ $movie['buyUrl'] ?? '#' }}">
                                    <span class="ticket-icon">✦</span>
                                    MUA VÉ
                                </a>
                            </article>
                        @empty
                            <div class="movie-empty">
                                <div>Không tìm thấy phim phù hợp.</div>
                                <a href="{{ route('movies.index', ['tab' => $activeTab]) }}" class="btn btn-default">Xóa lọc</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>
        </main>

        <footer class="footer">
            <div class="container footer-inner">
                <div class="footer-brand">
                    <div class="brand brand-footer">
                        <div class="brand-mark">beta</div>
                        <div class="brand-text">cinemas</div>
                    </div>
                    <ul>
                        @foreach (($footer['links'] ?? []) as $link)
                            <li><a href="#">{{ $link['label'] ?? '' }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div class="footer-column">
                    <h4>{{ $footer['cinemasTitle'] ?? 'CỤM RẠP BETA' }}</h4>
                    <ul>
                        @foreach (($footer['cinemas'] ?? []) as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="footer-column">
                    <h4>{{ $footer['contactTitle'] ?? 'LIÊN HỆ' }}</h4>
                    <p><strong>{{ $footer['companyName'] ?? '' }}</strong></p>
                    <p>{{ $footer['companyInfo'] ?? '' }}</p>
                    <p>{{ $footer['address'] ?? '' }}</p>
                    <p><strong>{{ $footer['supportLabel'] ?? '' }}</strong></p>
                    <p>{{ $footer['hotline'] ?? '' }}</p>
                    <p>{{ $footer['email'] ?? '' }}</p>
                </div>
            </div>
        </footer>
    </div>
    <script>
        (() => {
            document.querySelectorAll('[data-filter-form]').forEach((form) => {
                form.addEventListener('click', (event) => {
                    if (!event.target.matches('button[type="submit"]')) return;
                    event.preventDefault();
                    form.requestSubmit ? form.requestSubmit() : form.submit();
                });
            });
        })();
    </script>
</body>
</html>

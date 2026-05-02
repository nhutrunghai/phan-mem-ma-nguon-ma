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
                    <div class="section-header section-header--phim" role="tablist" aria-label="Danh sách phim">
                        @foreach ($movieTabs as $tab)
                            <a class="tab{{ ($tab['id'] ?? '') === $activeTab ? ' active' : '' }}" href="{{ route('movies.index', ['tab' => $tab['id'] ?? '']) }}">
                                {{ $tab['label'] ?? '' }}
                            </a>
                        @endforeach
                    </div>

                    <div class="movie-grid phim-grid">
                        @foreach ($movies as $movie)
                            @continue(($movie['section'] ?? '') !== $activeTab)
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
                        @endforeach
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
</body>
</html>

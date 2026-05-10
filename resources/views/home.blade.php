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
    <title>{{ $title ?? 'Beta Cinemas' }}</title>
    <link rel="stylesheet" href="{{ $assetPath('assets/css/style.css') }}">
</head>
<body>
    <div class="page-shell home-page">
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

                <nav class="nav">
                    @foreach ($navItems as $item)
                        <a href="{{ $item['href'] ?? '#' }}">{{ $item['label'] ?? '' }}</a>
                    @endforeach
                </nav>
            </div>
        </header>

        <main>
            <section class="hero">
                <div class="container hero-frame">
                    <button class="carousel-arrow left" type="button" aria-label="Trước">‹</button>
                    <div class="hero-slider" data-slider>
                        @foreach ($slides as $index => $slide)
                            <article class="hero-slide{{ $index === 0 ? ' active' : '' }}">
                                <img src="{{ $mediaPath($slide['image'] ?? '') }}" alt="{{ $slide['title'] ?? 'Banner' }}">
                            </article>
                        @endforeach
                    </div>
                    <button class="carousel-arrow right" type="button" aria-label="Sau">›</button>
                </div>
                <div class="hero-meta container">
                    <div class="hero-dots" aria-hidden="true">
                        @foreach ($slides as $index => $slide)
                            <span class="{{ $index === 0 ? 'active' : '' }}"></span>
                        @endforeach
                    </div>
                </div>
            </section>

            <section class="movies-section">
                <div class="container">
                    <div class="section-header">
                        <ul class="nav nav-tabs tab-films" role="tablist" aria-label="Danh sách phim">
                            @foreach ($movieTabs as $tab)
                                <li class="{{ !empty($tab['active']) ? 'active' : '' }}">
                                    <button class="tab{{ !empty($tab['active']) ? ' active' : '' }}" type="button" data-tab="{{ $tab['id'] ?? '' }}">
                                        <h1 class="font-20 font-sm-15 font-xs-9">{{ $tab['label'] ?? '' }}</h1>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="movie-grid" data-movie-grid>
                        @foreach ($movies as $movie)
                            <article class="movie-card" data-section="{{ $movie['section'] ?? 'now-showing' }}">
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
                                <a class="buy-ticket" href="{{ !empty($movie['scheduleDates']) ? ($movie['buyUrl'] ?? '#') : route('movies.index') }}">
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

    <script src="{{ $assetPath('assets/js/main.js') }}"></script>
</body>
</html>

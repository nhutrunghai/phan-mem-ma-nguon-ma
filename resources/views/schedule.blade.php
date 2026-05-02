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
    <div class="page-shell schedule-page-shell">
        <div class="topbar">
            <div class="container topbar-inner">
                <div></div>
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
                    <span class="flag">GB</span>
                </div>
            </div>
        </div>

        <header class="header">
            <div class="container header-inner">
                <a class="brand" href="{{ url('/') }}"><img class="brand-img" src="{{ $assetPath('assets/img/beta-logo.png') }}" alt="Beta Cinemas"></a>
                <button class="location-pill" type="button">Beta Thái Nguyên <span class="caret">▾</span></button>
                <nav class="nav">
                    @foreach ($navItems as $item)
                        <a href="{{ $item['href'] ?? '#' }}">{{ $item['label'] ?? '' }}</a>
                    @endforeach
                </nav>
            </div>
        </header>

        <main>
            <section class="container schedule-page schedule-page--compact schedule-page--source">
                <div class="section-header section-header--phim schedule-datebar schedule-datebar--top">
                    @foreach ($topScheduleDates as $date)
                        <button type="button" class="schedule-date {{ !empty($date['active']) ? 'active' : '' }}">
                            <span class="schedule-date__day">{{ $date['label'] ?? '' }}</span>
                            <span class="schedule-date__suffix">{{ $date['suffix'] ?? '' }}</span>
                        </button>
                    @endforeach
                </div>

                <div class="schedule-list">
                    @foreach ($scheduleMovies as $index => $entry)
                        @php($movie = $entry['movie'])
                        <article class="schedule-feature{{ $index === 0 ? ' schedule-feature--hero' : '' }}">
                            <div class="schedule-feature__poster{{ $index === 0 ? ' schedule-feature__poster--hero' : '' }}">
                                <img src="{{ $mediaPath($movie['poster'] ?? '') }}" alt="{{ $movie['title'] ?? '' }}">
                            </div>
                            <div class="schedule-feature__content">
                                <h1>{{ $movie['title'] ?? '' }}</h1>
                                <div class="schedule-feature__meta">
                                    <span>{{ $movie['genre'] ?? '' }}</span>
                                    <span>{{ $movie['duration'] ?? '' }} phút</span>
                                </div>
                                <div class="schedule-legend">
                                    <span class="schedule-legend__box"></span>
                                    Suất chiếu muộn từ 22h00
                                </div>
                                @foreach (($entry['activeGroups'] ?? []) as $group)
                                    <div class="schedule-group">
                                        <div class="schedule-group__title">{{ $group['format'] ?? '' }}</div>
                                        <div class="schedule-slot-grid">
                                            @foreach (($group['slots'] ?? []) as $slot)
                                                <a class="schedule-slot{{ !empty($slot['active']) ? ' active' : '' }}" href="{{ $movie['buyUrl'] ?? '#' }}">
                                                    <span class="schedule-slot__time">{{ $slot['time'] ?? '' }}</span>
                                                    <span class="schedule-slot__seats">{{ $slot['seats'] ?? '' }}</span>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        </main>

        <script>
            (() => {
                const dateButtons = Array.from(document.querySelectorAll('.schedule-date'));
                if (!dateButtons.length) return;

                dateButtons.forEach((button) => {
                    button.addEventListener('click', () => {
                        dateButtons.forEach((item) => item.classList.remove('active'));
                        button.classList.add('active');
                    });
                });
            })();
        </script>

        <footer class="footer">
            <div class="container footer-inner">
                <div class="footer-brand">
                    <div class="brand brand-footer"><img class="brand-img" src="{{ $assetPath('assets/img/beta-logo-white.png') }}" alt="Beta Cinemas"></div>
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

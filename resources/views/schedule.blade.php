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
        .schedule-filter {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 220px 120px 120px;
            gap: 10px;
            margin-bottom: 18px;
        }
        .schedule-empty {
            padding: 28px;
            text-align: center;
            color: #005198;
            background: #f4f8fc;
            border-radius: 12px;
            font-weight: 700;
        }
        @media (max-width: 767px) {
            .schedule-filter {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="page-shell schedule-page-shell">
        <div class="topbar">
            <div class="container topbar-inner">
                <div></div>
                <div class="topbar-links">
                    @if ($demoUser)
                        <a href="{{ route('account.show') }}">{{ $demoUser['name'] }}</a>
                        <span>|</span>
                        <a href="{{ route('auth.logout') }}">Đăng xuất</a>
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
                <nav class="nav">
                    @foreach ($navItems as $item)
                        <a href="{{ $item['href'] ?? '#' }}">{{ $item['label'] ?? '' }}</a>
                    @endforeach
                </nav>
            </div>
        </header>

        <main>
            <section class="container schedule-page schedule-page--compact schedule-page--source">
                <form class="schedule-filter" method="get" action="{{ route('schedule.index') }}" data-filter-form>
                    <input type="hidden" name="date" value="{{ $activeScheduleDate ?? '' }}">
                    <input type="text" name="q" class="form-control" placeholder="Tìm theo tên phim" value="{{ $search ?? '' }}">
                    <input type="text" name="genre" class="form-control" placeholder="Lọc theo thể loại" value="{{ $genre ?? '' }}">
                    <button type="submit" class="btn btn-primary">Lọc</button>
                    <a href="{{ route('schedule.index') }}" class="btn btn-default">Xóa lọc</a>
                </form>

                <div class="section-header section-header--phim schedule-datebar schedule-datebar--top">
                    @foreach ($topScheduleDates as $date)
                        @php($dateKey = trim(($date['label'] ?? '') . ($date['suffix'] ?? '')))
                        <a class="schedule-date {{ !empty($date['active']) ? 'active' : '' }}" href="{{ route('schedule.index', ['date' => $dateKey, 'q' => $search ?? '', 'genre' => $genre ?? '']) }}">
                            <span class="schedule-date__day">{{ $date['label'] ?? '' }}</span>
                            <span class="schedule-date__suffix">{{ $date['suffix'] ?? '' }}</span>
                        </a>
                    @endforeach
                </div>

                <div class="schedule-list">
                    @forelse ($scheduleMovies as $index => $entry)
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
                                                <a class="schedule-slot{{ !empty($slot['active']) ? ' active' : '' }}" href="{{ route('booking.seats', ['id' => $movie['id'] ?? '', 'showtime' => $slot['id'] ?? '', 'date' => $entry['selectedDate'] ?? ($activeScheduleDate ?? ''), 'time' => $slot['time'] ?? '', 'format' => $group['format'] ?? '2D']) }}">
                                                    <span class="schedule-slot__time">{{ $slot['time'] ?? '' }}</span>
                                                    <span class="schedule-slot__seats">{{ $slot['seats'] ?? '' }}</span>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @empty
                        <div class="schedule-empty">Không tìm thấy lịch chiếu phù hợp.</div>
                    @endforelse
                </div>
            </section>
        </main>

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

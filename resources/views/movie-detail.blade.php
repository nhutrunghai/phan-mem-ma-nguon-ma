@php
    $demoUser = session('demo_user');
    $assetPath = static fn (string $path): string => asset('web-home/' . ltrim($path, '/'));
    $mediaPath = static fn (?string $path): string => str_starts_with((string) $path, 'http')
        ? (string) $path
        : asset('web-home/' . ltrim((string) $path, '/'));
    $scheduleDates = $movie['scheduleDates'] ?? [];
    $showtimeGroups = $movie['showtimeGroups'] ?? [];
    $scheduleByDate = $movie['scheduleByDate'] ?? [];
    $showtimes = $movie['showtimes'] ?? [];
    $activeDateIndex = 0;
    foreach ($scheduleDates as $index => $date) {
        if (!empty($date['active'])) {
            $activeDateIndex = $index;
            break;
        }
    }
    if ($scheduleByDate === [] && $scheduleDates !== []) {
        $scheduleByDate[] = [
            'label' => $scheduleDates[0]['label'] ?? '',
            'suffix' => $scheduleDates[0]['suffix'] ?? '',
            'active' => true,
            'groups' => $showtimeGroups,
        ];
    }
    $activeGroups = $scheduleByDate[$activeDateIndex]['groups'] ?? $showtimeGroups;
    $firstScheduleGroup = $activeGroups[0] ?? [];
    $firstScheduleSlot = $firstScheduleGroup['slots'][0] ?? [];
    $trailerUrl = $movie['trailer'] ?? null;
    preg_match('~(?:youtu\.be/|v=|embed/)([^?&/]+)~', (string) $trailerUrl, $trailerMatch);
    $trailerId = $trailerMatch[1] ?? '';
    $trailerThumb = $trailerId !== '' ? "https://img.youtube.com/vi/{$trailerId}/hqdefault.jpg" : null;
@endphp
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ $assetPath('assets/css/style.css') }}">
</head>
<body class="detail-shell">
    <div class="page-shell detail-page-shell">
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

        <main class="detail-page">
            <div class="container">
                <h3 class="detail-breadcrumb">Trang chủ &gt; <span>{{ $movie['title'] ?? '' }}</span></h3>
            </div>

            <section class="container detail-hero">
                <div class="detail-poster">
                    <img src="{{ $mediaPath($movie['poster'] ?? '') }}" alt="{{ $movie['title'] ?? '' }}">
                </div>

                <div class="detail-content">
                    <div class="detail-badge">{{ $movie['label'] ?? '' }}</div>
                    <h1>{{ $movie['title'] ?? '' }}</h1>
                    <p class="detail-description">{{ $movie['description'] ?? 'Nội dung phim đang được cập nhật.' }}</p>

                    <div class="detail-info">
                        @foreach (($movie['details'] ?? []) as $row)
                            <div><span>{{ $row['label'] ?? '' }}:</span> {{ $row['value'] ?? '' }}</div>
                        @endforeach
                    </div>

                    <div class="detail-actions">
                        <a class="buy-ticket" href="javascript:void(0)">
                            <span class="ticket-icon">✦</span>
                            MUA VÉ NGAY
                        </a>
                    </div>

                    @if ($scheduleDates || $showtimeGroups)
                        <section class="detail-schedule">
                            @if ($scheduleDates)
                                <div class="schedule-datebar schedule-datebar--top" data-schedule-dates>
                                    @foreach ($scheduleDates as $date)
                                        <button
                                            type="button"
                                            class="schedule-date{{ !empty($date['active']) ? ' active' : '' }}"
                                            data-schedule-date="{{ ($date['label'] ?? '') . ($date['suffix'] ?? '') }}">
                                            <span class="schedule-date__day">{{ $date['label'] ?? '' }}</span>
                                            <span class="schedule-date__suffix">{{ $date['suffix'] ?? '' }}</span>
                                        </button>
                                    @endforeach
                                </div>
                            @endif

                            <div class="schedule-panels" data-schedule-panels>
                                @foreach ($scheduleByDate as $dateIndex => $date)
                                    <div class="schedule-panel{{ $dateIndex === $activeDateIndex ? ' active' : '' }}" data-schedule-panel="{{ ($date['label'] ?? '') . ($date['suffix'] ?? '') }}">
                                        @foreach (($date['groups'] ?? []) as $group)
                                            <div class="schedule-group">
                                                <div class="schedule-group__title">{{ $group['format'] ?? '' }}</div>
                                                <div class="schedule-slot-grid">
                                                    @foreach (($group['slots'] ?? []) as $slot)
                                                        <div class="schedule-slot-item">
                                                            <button type="button" class="schedule-slot{{ !empty($slot['active']) ? ' active' : '' }}" data-showtime
                                                                data-cinema="Beta Thái Nguyên"
                                                                data-date="{{ ($date['label'] ?? '') . ($date['suffix'] ?? '') }}"
                                                                data-time="{{ $slot['time'] ?? '' }}">
                                                                <span class="schedule-slot__time">{{ $slot['time'] ?? '' }}</span>
                                                                <span class="schedule-slot__date{{ !empty($slot['active']) ? ' is-visible' : '' }}">{{ $date['label'] ?? '' }}/{{ str_replace([' - T2', ' - T3', ' - T4', ' - T5', ' - T6', ' - T7', ' - CN'], '', $date['suffix'] ?? '') }}</span>
                                                            </button>
                                                            <div class="schedule-slot__seats">{{ $slot['seats'] ?? '' }}</div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>
            </section>

            @if ($trailerUrl)
                <section class="detail-trailer-section">
                    <div class="container">
                        <h2 class="detail-trailer-title">TRAILER</h2>
                        <div class="trailer-frame trailer-frame--hero">
                            @if ($trailerThumb)
                                <img class="trailer-frame__thumb" src="{{ $trailerThumb }}" alt="Trailer thumbnail">
                            @endif
                            <iframe
                                src="{{ $trailerUrl }}"
                                title="Trailer phim"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                            <div class="trailer-frame__overlay">
                                <div class="trailer-frame__play">▶</div>
                                <div class="trailer-frame__title">{{ $movie['title'] ?? '' }} Official Trailer</div>
                                <a class="trailer-frame__youtube" href="{{ str_replace('/embed/', '/watch?v=', $trailerUrl) }}" target="_blank" rel="noreferrer">Xem trên YouTube</a>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            @if ($showtimes)
                <section class="container detail-showtimes">
                    <h2>LỊCH CHIẾU</h2>
                    <div class="showtime-list">
                        @foreach ($showtimes as $slot)
                            <article class="showtime-card" data-showtime
                                data-cinema="Beta Thái Nguyên"
                                data-date="{{ $slot['date'] ?? '' }}"
                                data-time="{{ $slot['time'] ?? '' }}">
                                <div class="showtime-date">{{ $slot['date'] ?? '' }}</div>
                                <div class="showtime-format">{{ $slot['format'] ?? '' }}</div>
                                <div class="showtime-time">{{ $slot['time'] ?? '' }}</div>
                                <button type="button" class="showtime-seats showtime-seats-btn">{{ $slot['seats'] ?? '' }}</button>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
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

        <div class="booking-modal" id="bookingModal" aria-hidden="true">
            <div class="booking-modal__backdrop" data-close-modal></div>
            <div class="booking-modal__panel" role="dialog" aria-modal="true" aria-labelledby="bookingTitle">
                <button type="button" class="booking-modal__close" aria-label="Đóng" data-close-modal>&times;</button>
                <div class="booking-modal__header">
                    <h3 id="bookingTitle">BẠN ĐANG ĐẶT VÉ XEM PHIM</h3>
                </div>
                <div class="booking-modal__movie">
                    {{ $movie['title'] ?? '' }}
                </div>
                <div class="booking-modal__table">
                    <div class="booking-modal__row booking-modal__row--head">
                        <div>Rạp chiếu</div>
                        <div>Ngày chiếu</div>
                        <div>Giờ chiếu</div>
                    </div>
                    <div class="booking-modal__row">
                        <div data-modal-cinema>Beta Thái Nguyên</div>
                        <div data-modal-date>{{ ($scheduleDates[0]['label'] ?? '') . ($scheduleDates[0]['suffix'] ?? '') }}</div>
                        <div data-modal-time>{{ $firstScheduleSlot['time'] ?? ($showtimes[0]['time'] ?? '') }}</div>
                    </div>
                </div>
                <div class="booking-modal__footer">
                    <a class="booking-modal__confirm" href="javascript:void(0)" data-booking-url="{{ route('booking.seats', ['id' => $movie['id']]) }}">ĐỒNG Ý</a>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ $assetPath('assets/js/detail.js') }}"></script>
</body>
</html>

@php
    $mediaPath = static fn (?string $path): string => str_starts_with((string) $path, 'http')
        ? (string) $path
        : asset('web-home/' . ltrim((string) $path, '/'));
    $details = collect($movie['details'] ?? []);
    $genre = $details->firstWhere('label', 'Thể loại')['value'] ?? ($movie['genre'] ?? 'Đang cập nhật');
    $duration = $details->firstWhere('label', 'Thời lượng')['value'] ?? ((int) ($movie['duration'] ?? 0) > 0 ? ($movie['duration'] . ' phút') : 'Đang cập nhật');
    $ageLimit = '16';

    if (preg_match('/(\d+)/', (string) ($movie['label'] ?? ''), $ageMatch)) {
        $ageLimit = $ageMatch[1];
    }
@endphp
<div class="margin-none seat-page-shell">
    <style>
        .seat-page-shell {
            background: #fff;
            padding-bottom: 0;
        }
        .seat-page {
            max-width: 1280px;
            margin: 0 auto;
            padding: 20px 14px 24px;
            color: #273247;
            font-family: "Montserrat-Regular", Arial, sans-serif;
        }
        .seat-breadcrumb {
            margin: 0 0 18px;
            font: 700 18px "Montserrat", Arial, sans-serif;
            color: #005198;
        }
        .seat-breadcrumb a {
            color: #005198;
            text-decoration: none;
        }
        .seat-layout {
            display: grid;
            grid-template-columns: minmax(0, 1fr) 312px;
            gap: 0;
            align-items: start;
            border-top: 1px solid #eef2f7;
        }
        .seat-main {
            min-width: 0;
            padding: 16px 28px 0 0;
        }
        .seat-warning {
            background: #ffc15a;
            color: #ff1f00;
            text-align: center;
            font: 700 14px "Montserrat", Arial, sans-serif;
            padding: 12px 16px;
            margin-bottom: 14px;
        }
        .seat-legend {
            display: flex;
            flex-wrap: wrap;
            gap: 22px;
            align-items: center;
            margin-bottom: 16px;
        }
        .seat-legend__item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font: 700 13px "Montserrat-Medium", Arial, sans-serif;
            color: #273247;
        }
        .seat-chip {
            position: relative;
            width: 30px;
            height: 23px;
            border-radius: 13px 13px 9px 9px;
            border: 3px solid currentColor;
            background: currentColor;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #bfc2cf;
            flex: 0 0 auto;
        }
        .seat-chip::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: -7px;
            transform: translateX(-50%);
            width: 26px;
            height: 7px;
            border: 3px solid currentColor;
            border-top: 0;
            border-radius: 0 0 12px 12px;
            background: transparent;
        }
        .seat-chip--available {
            color: #bfc2cf;
            background: #ececf3;
        }
        .seat-chip--selected {
            color: #005fb3;
            background: #1c78c8;
        }
        .seat-chip--held {
            color: #47b7ff;
            background: #7aceff;
        }
        .seat-chip--sold {
            color: #ff3b12;
            background: #ff4a1f;
        }
        .seat-chip--reserved {
            color: #ffc107;
            background: #ffd34d;
        }
        .seat-screen {
            position: relative;
            height: 76px;
            margin: 8px 0 18px;
            border-radius: 50% / 100% 100% 0 0;
            background: radial-gradient(circle at 50% 100%, rgba(0, 81, 152, 0.12), rgba(255, 255, 255, 0.98) 58%);
            box-shadow: inset 0 18px 28px rgba(0, 81, 152, 0.05);
        }
        .seat-screen::before {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            top: 16px;
            height: 9px;
            border-radius: 999px;
            background: linear-gradient(180deg, #7785a0, #455777);
            box-shadow: 0 2px 0 rgba(255, 255, 255, 0.8), 0 8px 18px rgba(69, 87, 119, 0.14);
        }
        .seat-screen__label {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font: 500 22px "Montserrat-Regular", Arial, sans-serif;
            letter-spacing: .5px;
            color: #a4a8b0;
        }
        .seat-map {
            display: flex;
            flex-direction: column;
            gap: 8px;
            align-items: center;
            padding-bottom: 14px;
        }
        .seat-map-wrap {
            overflow-x: auto;
            padding: 0 8px 14px;
        }
        .seat-map-hint {
            display: none;
            margin: -4px 0 10px;
            color: #005198;
            font: 700 12px "Montserrat-Medium", Arial, sans-serif;
            text-align: center;
        }
        .seat-row {
            display: flex;
            gap: 8px;
            justify-content: center;
        }
        .seat {
            width: 38px;
            height: 34px;
            position: relative;
            border: 0;
            padding: 0 0 8px;
            background: transparent;
            cursor: pointer;
        }
        .seat:disabled {
            cursor: not-allowed;
        }
        .seat__back {
            position: absolute;
            inset: 0 0 8px;
            border-radius: 13px 13px 9px 9px;
            background: #ececf3;
            border: 3px solid #bfc2cf;
            transition: transform .2s ease, background-color .2s ease, border-color .2s ease;
        }
        .seat__base {
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 31px;
            height: 8px;
            border-radius: 0 0 12px 12px;
            border: 3px solid #bfc2cf;
            border-top: 0;
            background: transparent;
            transition: border-color .2s ease;
        }
        .seat__label {
            position: relative;
            z-index: 1;
            display: block;
            font: 700 11px/26px "Montserrat-Medium", Arial, sans-serif;
            color: #58627b;
            text-align: center;
        }
        .seat:hover .seat__back {
            transform: translateY(-1px);
        }
        .seat.is-selected .seat__back,
        .seat.is-sold .seat__back {
            background: #ff4a1f;
            border-color: #ff3b12;
        }
        .seat.is-selected .seat__base,
        .seat.is-sold .seat__base {
            border-color: #ff3b12;
        }
        .seat.is-selected .seat__label,
        .seat.is-sold .seat__label,
        .seat.is-held .seat__label,
        .seat.is-reserved .seat__label {
            color: #fff;
        }
        .seat.is-selected .seat__back {
            background: #1c78c8;
            border-color: #005fb3;
        }
        .seat.is-selected .seat__base {
            border-color: #005fb3;
        }
        .seat.is-held .seat__back {
            background: #7aceff;
            border-color: #47b7ff;
        }
        .seat.is-held .seat__base {
            border-color: #47b7ff;
        }
        .seat.is-reserved .seat__back {
            background: #ffd34d;
            border-color: #ffc107;
        }
        .seat.is-reserved .seat__base {
            border-color: #ffc107;
        }
        .seat-sidebar {
            background: #fff;
            border-left: 1px solid #e8edf4;
        }
        .seat-sidebar__inner {
            padding: 0 0 18px;
        }
        .seat-sidebar__top {
            display: grid;
            grid-template-columns: 146px 1fr;
            gap: 18px;
            padding: 0 0 18px;
        }
        .seat-sidebar__poster img {
            width: 100%;
            display: block;
        }
        .seat-sidebar__info {
            padding: 14px 14px 0 0;
        }
        .seat-sidebar__title {
            margin: 0 0 10px;
            color: #005198;
            font: 700 22px/1.25 "Montserrat", Arial, sans-serif;
        }
        .seat-sidebar__format {
            font: 700 18px/1.3 "Montserrat", Arial, sans-serif;
            color: #273247;
        }
        .seat-summary {
            border-top: 2px dashed #d7dde8;
            padding: 18px 22px 0;
        }
        .seat-summary__row {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 14px;
            align-items: start;
            margin-bottom: 18px;
            font-size: 13px;
        }
        .seat-summary__label {
            color: #273247;
            font: 500 13px/1.35 "Montserrat-Regular", Arial, sans-serif;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }
        .seat-summary__value {
            color: #273247;
            font: 700 13px/1.35 "Montserrat-Medium", Arial, sans-serif;
        }
        .seat-summary__seats {
            min-height: 22px;
            color: #005198;
            font: 700 13px/1.45 "Montserrat-Medium", Arial, sans-serif;
        }
        .seat-continue {
            margin: 18px 22px 0;
            width: 140px;
            border: 0;
            border-radius: 14px !important;
            background: #005198;
            color: #fff;
            font: 700 15px "Montserrat", Arial, sans-serif;
            padding: 13px 18px;
            transition: opacity .2s ease, transform .2s ease;
            display: block;
        }
        .seat-bottom {
            margin-top: 22px;
            display: grid;
            grid-template-columns: 1.8fr 140px 160px;
            background: #fff;
            border: 1px solid #edf1f6;
        }
        .seat-bottom__section {
            min-height: 104px;
            padding: 14px 18px;
        }
        .seat-bottom__section + .seat-bottom__section {
            border-left: 1px solid #d8dde6;
        }
        .seat-pricing {
            display: flex;
            align-items: flex-start;
            gap: 28px;
            flex-wrap: wrap;
        }
        .seat-pricing__item {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #273247;
            font: 700 13px "Montserrat-Medium", Arial, sans-serif;
        }
        .seat-bottom__title {
            text-align: center;
            color: #273247;
            font: 700 14px "Montserrat", Arial, sans-serif;
            margin-top: 2px;
        }
        .seat-bottom__value {
            text-align: center;
            color: #005198;
            font: 700 17px "Montserrat", Arial, sans-serif;
            margin-top: 34px;
        }
        .seat-bottom__countdown {
            text-align: center;
            color: #161e31;
            font: 700 31px/1 "Montserrat", Arial, sans-serif;
            margin-top: 16px;
        }
        .seat-bottom__countdown.is-warning {
            color: #d44817;
        }
        .seat-continue[disabled] {
            opacity: .5;
            cursor: not-allowed;
        }
        .seat-helper {
            margin: 10px 22px 0;
            color: #d44817;
            font: 700 12px "Montserrat-Medium", Arial, sans-serif;
        }
        .seat-continue:not([disabled]):hover {
            transform: translateY(-1px);
        }
        @media (max-width: 1100px) {
            .seat-layout {
                grid-template-columns: 1fr;
            }
            .seat-main {
                padding-right: 0;
            }
            .seat-sidebar {
                border-left: 0;
            }
        }
        @media (max-width: 767px) {
            .seat-page {
                padding: 16px 12px 20px;
            }
            .seat-breadcrumb {
                font-size: 15px;
            }
            .seat-warning {
                font-size: 13px;
            }
            .seat-sidebar__top {
                grid-template-columns: 118px 1fr;
                gap: 14px;
            }
            .seat-sidebar__title {
                font-size: 18px;
            }
            .seat-sidebar__format {
                font-size: 16px;
            }
            .seat-summary {
                padding: 18px 16px 0;
            }
            .seat-summary__row {
                grid-template-columns: 1fr;
                gap: 6px;
                margin-bottom: 16px;
            }
            .seat-bottom {
                grid-template-columns: 1fr;
            }
            .seat-bottom__section + .seat-bottom__section {
                border-left: 0;
                border-top: 1px solid #d8dde6;
            }
            .seat-continue {
                width: calc(100% - 32px);
                margin: 18px 16px 0;
            }
            .seat {
                width: 34px;
                height: 31px;
            }
            .seat__base {
                width: 27px;
            }
            .seat-map {
                align-items: flex-start;
                min-width: 390px;
            }
            .seat-map-hint {
                display: block;
            }
        }
    </style>

    <div class="seat-page">
        @if (session('status'))
            <div style="margin-bottom:16px;padding:12px 14px;background:#e8f5e9;color:#1b5e20;font-weight:700;border-radius:10px;">
                {{ session('status') }}
            </div>
        @endif
        @if ($errors->any())
            <div style="margin-bottom:16px;padding:12px 14px;background:#ffebee;color:#b71c1c;font-weight:700;border-radius:10px;">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('booking.store', ['id' => $movie['id'] ?? '']) }}" id="bookingForm">
            @csrf
            <input type="hidden" name="cinema" value="{{ $selectedCinema }}">
            <input type="hidden" name="show_date" value="{{ $selectedDate }}">
            <input type="hidden" name="show_time" value="{{ $selectedTime }}">
            <input type="hidden" name="format" value="{{ $selectedFormat }}">
            <input type="hidden" name="seats" value="{{ implode(',', $preselectedSeats) }}" data-seat-input>
        <div class="seat-breadcrumb">
            <a href="{{ url('/') }}">Trang chủ</a> &gt; Đặt vé &gt; {{ $movie['title'] ?? '' }}
        </div>

        <div class="seat-layout">
            <div class="seat-main">
                <div class="seat-warning">
                    Theo quy định của cục điện ảnh, phim này không dành cho khán giả dưới {{ $ageLimit }} tuổi.
                </div>

                <div class="seat-legend">
                    <span class="seat-legend__item"><span class="seat-chip seat-chip--available"></span>Ghế trống</span>
                    <span class="seat-legend__item"><span class="seat-chip seat-chip--selected"></span>Ghế đang chọn</span>
                    <span class="seat-legend__item"><span class="seat-chip seat-chip--held"></span>Ghế đang giữ</span>
                    <span class="seat-legend__item"><span class="seat-chip seat-chip--sold"></span>Ghế đã bán</span>
                    <span class="seat-legend__item"><span class="seat-chip seat-chip--reserved"></span>Ghế đặt trước</span>
                </div>

                <div class="seat-screen">
                    <div class="seat-screen__label">MÀN HÌNH CHIẾU</div>
                </div>

                <div class="seat-map-hint">Vuốt ngang để xem thêm ghế</div>
                <div class="seat-map-wrap">
                <div class="seat-map" data-seat-map>
                    @foreach ($seatRows as $rowLabel => $numbers)
                        <div class="seat-row">
                            @foreach ($numbers as $number)
                                @php
                                    $seatCode = $rowLabel . $number;
                                    $state = 'available';
                                    if (in_array($seatCode, $soldSeats, true)) {
                                        $state = 'sold';
                                    } elseif (in_array($seatCode, $heldSeats, true)) {
                                        $state = 'held';
                                    } elseif (in_array($seatCode, $reservedSeats, true)) {
                                        $state = 'reserved';
                                    } elseif (in_array($seatCode, $preselectedSeats, true)) {
                                        $state = 'selected';
                                    }
                                @endphp
                                <button
                                    type="button"
                                    class="seat{{ $state !== 'available' ? ' is-' . $state : '' }}"
                                    data-seat="{{ $seatCode }}"
                                    data-state="{{ $state }}"
                                    @disabled($state === 'sold' || $state === 'held' || $state === 'reserved')>
                                    <span class="seat__back"></span>
                                    <span class="seat__label">{{ $seatCode }}</span>
                                    <span class="seat__base"></span>
                                </button>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                </div>

                <div class="seat-bottom">
                    <div class="seat-bottom__section">
                        <div class="seat-pricing">
                            <span class="seat-pricing__item"><span class="seat-chip seat-chip--available"></span>Ghế thường</span>
                            <span class="seat-pricing__item"><span class="seat-chip seat-chip--available"></span>Ghế VIP</span>
                            <span class="seat-pricing__item"><span class="seat-chip seat-chip--available"></span>Ghế đôi</span>
                        </div>
                    </div>
                    <div class="seat-bottom__section">
                        <div class="seat-bottom__title">Tổng tiền</div>
                        <div class="seat-bottom__value" data-seat-total>0 vnđ</div>
                    </div>
                    <div class="seat-bottom__section">
                        <div class="seat-bottom__title">Thời gian còn lại</div>
                        <div class="seat-bottom__countdown" data-seat-timer>10:00</div>
                    </div>
                </div>
            </div>

            <aside class="seat-sidebar">
                <div class="seat-sidebar__inner">
                    <div class="seat-sidebar__top">
                        <div class="seat-sidebar__poster">
                            <img src="{{ $mediaPath($movie['poster'] ?? '') }}" alt="{{ $movie['title'] ?? '' }}">
                        </div>
                        <div class="seat-sidebar__info">
                            <h1 class="seat-sidebar__title">{{ $movie['title'] ?? '' }}</h1>
                            <div class="seat-sidebar__format">{{ $selectedFormat }}</div>
                        </div>
                    </div>

                    <div class="seat-summary">
                        <div class="seat-summary__row">
                            <div class="seat-summary__label"><i class="fa fa-tag" aria-hidden="true"></i>Thể loại</div>
                            <div class="seat-summary__value">{{ $genre }}</div>
                        </div>
                        <div class="seat-summary__row">
                            <div class="seat-summary__label"><i class="fa fa-clock-o" aria-hidden="true"></i>Thời lượng</div>
                            <div class="seat-summary__value">{{ $duration }}</div>
                        </div>
                        <div class="seat-summary__row">
                            <div class="seat-summary__label"><i class="fa fa-university" aria-hidden="true"></i>Rạp chiếu</div>
                            <div class="seat-summary__value">{{ $selectedCinema }}</div>
                        </div>
                        <div class="seat-summary__row">
                            <div class="seat-summary__label"><i class="fa fa-calendar" aria-hidden="true"></i>Ngày chiếu</div>
                            <div class="seat-summary__value">{{ $selectedDate }}</div>
                        </div>
                        <div class="seat-summary__row">
                            <div class="seat-summary__label"><i class="fa fa-clock-o" aria-hidden="true"></i>Giờ chiếu</div>
                            <div class="seat-summary__value">{{ $selectedTime }}</div>
                        </div>
                        <div class="seat-summary__row">
                            <div class="seat-summary__label"><i class="fa fa-cubes" aria-hidden="true"></i>Ghế ngồi</div>
                            <div class="seat-summary__seats" data-seat-summary>{{ implode(', ', $preselectedSeats) }}</div>
                        </div>
                    </div>

                    <button type="submit" class="seat-continue" data-seat-continue>TIẾP TỤC</button>
                    <div class="seat-helper" data-seat-helper>Vui lòng chọn ghế để tiếp tục.</div>
                </div>
            </aside>
        </div>
        </form>
    </div>

    <script>
        (function () {
            var seatButtons = Array.prototype.slice.call(document.querySelectorAll('[data-seat]'));
            var summary = document.querySelector('[data-seat-summary]');
            var continueButton = document.querySelector('[data-seat-continue]');
            var total = document.querySelector('[data-seat-total]');
            var timer = document.querySelector('[data-seat-timer]');
            var seatInput = document.querySelector('[data-seat-input]');
            var seatMap = document.querySelector('[data-seat-map]');
            var helper = document.querySelector('[data-seat-helper]');
            var selectedSeats = seatButtons
                .filter(function (button) { return button.dataset.state === 'selected'; })
                .map(function (button) { return button.dataset.seat; });
            var seatPrice = 50000;
            var remainingSeconds = 600;

            function renderCountdown() {
                if (!timer) {
                    return;
                }

                var minutes = Math.floor(remainingSeconds / 60);
                var seconds = remainingSeconds % 60;
                timer.textContent = minutes + ':' + String(seconds).padStart(2, '0');
                timer.classList.toggle('is-warning', remainingSeconds <= 120);
            }

            function renderSelection() {
                selectedSeats.sort(function (a, b) {
                    return a.localeCompare(b, undefined, { numeric: true });
                });

                if (summary) {
                    summary.textContent = selectedSeats.length ? selectedSeats.join(', ') : 'Chưa chọn ghế';
                }

                if (total) {
                    total.textContent = (selectedSeats.length * seatPrice).toLocaleString('vi-VN') + ' vnđ';
                }

                if (seatInput) {
                    seatInput.value = selectedSeats.join(',');
                }

                if (continueButton) {
                    continueButton.disabled = selectedSeats.length === 0;
                }

                if (helper) {
                    helper.style.display = selectedSeats.length === 0 ? 'block' : 'none';
                }
            }

            if (seatMap) {
                seatMap.addEventListener('click', function (event) {
                    var button = event.target.closest('[data-seat]');
                    if (!button || button.disabled) {
                        return;
                    }

                    if (button.dataset.state !== 'available' && button.dataset.state !== 'selected') {
                        return;
                    }

                    var seatCode = button.dataset.seat;
                    var index = selectedSeats.indexOf(seatCode);

                    if (index >= 0) {
                        selectedSeats.splice(index, 1);
                        button.dataset.state = 'available';
                        button.classList.remove('is-selected');
                    } else {
                        selectedSeats.push(seatCode);
                        button.dataset.state = 'selected';
                        button.classList.add('is-selected');
                    }

                    renderSelection();
                });
            } else {
                seatButtons.forEach(function (button) {
                    if (button.dataset.state !== 'available' && button.dataset.state !== 'selected') {
                        return;
                    }

                    button.addEventListener('click', function () {
                        var seatCode = button.dataset.seat;
                        var index = selectedSeats.indexOf(seatCode);

                        if (index >= 0) {
                            selectedSeats.splice(index, 1);
                            button.dataset.state = 'available';
                            button.classList.remove('is-selected');
                        } else {
                            selectedSeats.push(seatCode);
                            button.dataset.state = 'selected';
                            button.classList.add('is-selected');
                        }

                        renderSelection();
                    });
                });
            }
            renderSelection();
            renderCountdown();

            window.setInterval(function () {
                if (remainingSeconds === 0) {
                    return;
                }

                remainingSeconds -= 1;
                renderCountdown();
            }, 1000);
        })();
    </script>
</div>

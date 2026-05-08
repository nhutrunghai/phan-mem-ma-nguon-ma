# UI Fix Report

Date: 2026-05-05

## Changed Files

- `resources/views/movie-detail.blade.php`
- `resources/views/seat-selection-content.blade.php`
- `resources/views/schedule.blade.php`
- `resources/views/movies.blade.php`
- `public/web-home/assets/css/style.css`
- `routes/web.php`
- `resources/views/errors/404.blade.php`

## Fixes

- Wired the movie detail buy-now CTA to the booking route and supplied showtime metadata so the booking modal/route has a real next step.
- Fixed movie detail showtime date rendering so compact slot labels render as `29/04` instead of `29//04`.
- Made seat selection update selected state, hidden seat input, total, disabled state, and inline helper text; added a mobile horizontal scroll cue for the seat map.
- Kept booking continue disabled until at least one seat is selected.
- Made movie and schedule filters submit through normal GET URLs with a small click fallback; added nearby reset actions for empty movie results.
- Made schedule date pills real links with a `date` query parameter, and ensured schedule booking links use the selected date.
- Reduced mobile schedule date pill weight by keeping dates on one horizontal scroll row.
- Added mobile home header spacing so wrapped navigation no longer overlaps the carousel area.
- Suppressed imported auth-page auto modal after load and replaced/removed broken imported CAPTCHA, GTM, Facebook, Cloudflare, manifest, and back-to-top image references where they caused local page errors.
- Added a branded 404 page with links back to movies and home.
- Fixed the main `/dat-ve/{id}` page rendering blank in the browser by serving seat selection through the Laravel layout and including the existing seat-selection partial directly.

## Verification

- `php -l routes/web.php`
- `php -l app/Http/Controllers/BookingController.php`
- `php -l app/Services/MovieCatalog.php`
- `php artisan route:list --path=phim`
- `php artisan test` passed: 2 tests, 2 assertions.
- Post-regression fix:
  - `/dat-ve/phi-phong-quy-mau-rung-thieng` returns rendered seat content with `bookingForm` and `seat-page-shell`.
  - Playwright verified 80 seats render, selecting a seat updates selected state/hidden input/total, and submit creates a `BK-*` booking in account history.
- Started a temporary local server on `http://127.0.0.1:8010` and checked:
  - `/phim`
  - `/phim?tab=upcoming&q=zzzzzz&genre=`
  - `/lich-chieu?date=30/04`
  - `/phim/phi-phong-quy-mau-rung-thieng`
  - `/dat-ve/phi-phong-quy-mau-rung-thieng`
  - `/dang-nhap`
  - `/phim/not-a-real-movie`

Note: Playwright MCP was unavailable because its browser profile was already in use, so verification used Laravel tests and targeted HTTP/render checks.

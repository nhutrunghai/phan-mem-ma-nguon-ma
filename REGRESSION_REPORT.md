# Regression Report

Date: 2026-05-05

## Environment

- App: `http://127.0.0.1:8000`
- Vite: `http://127.0.0.1:5173`
- Browser testing: Playwright MCP
- Auth state: demo member session was available during booking/account checks.

## Summary

Most issues from `TEST_REPORT.md` are fixed after the UI pass. One critical regression was found during this pass: the main booking page returned HTTP 200 but rendered blank in the browser because the controller wrapped seat content into an old mirrored shell that no longer matched the expected marker. That was fixed during regression by serving the existing seat-selection partial through the Laravel layout.

## Rechecked Issues

### 1. Movie Detail Buy CTA

- Status: Fixed
- Route: `/phim/phi-phong-quy-mau-rung-thieng`
- Steps: Open movie detail and click `MUA VÉ NGAY`.
- Expected: User reaches the booking/seat-selection flow with movie/showtime context.
- Actual: CTA links to `/dat-ve/phi-phong-quy-mau-rung-thieng?...` and opens the booking page.
- Notes: No layout breakage observed at desktop width.

### 2. Booking Page Render

- Status: Fixed after regression patch
- Route: `/dat-ve/phi-phong-quy-mau-rung-thieng`
- Steps: Open the booking URL from the movie detail CTA.
- Expected: Seat map, booking summary, total, and continue action are visible.
- Actual before regression patch: HTTP 200 but page body was effectively blank, with only the imported back-to-top element visible.
- Actual after regression patch: Seat page renders with 80 seats, summary, total, timer, and continue button.
- Visual/UI notes: Current layout is preserved through the standard header/footer shell.

### 3. Seat Selection State

- Status: Fixed
- Route: `/dat-ve/phi-phong-quy-mau-rung-thieng`
- Steps: Select the first available seat.
- Expected: Seat becomes selected, hidden `seats` input updates, total price updates, continue button enables.
- Actual: Selecting `H11` set `input[name="seats"]` to `H11`, selected count became 1, total changed to `50.000 vnđ`, and submit became enabled.

### 4. Booking Submit And Account History

- Status: Fixed
- Route: `/dat-ve/...` to `/tai-khoan?tab=history`
- Steps: Select a seat and submit while logged in with the demo member session.
- Expected: Booking persists and history shows a generated ticket code.
- Actual: Submit redirected to `/tai-khoan?tab=history`; account history displayed `BK-*` booking codes.

### 5. Movie Filter Empty State

- Status: Fixed
- Route: `/phim?tab=upcoming&q=zzzzzz&genre=`
- Steps: Search for a string with no matching movie.
- Expected: Clear empty state and reset action.
- Actual: Page shows `Không tìm thấy phim phù hợp.` and `Xóa lọc` actions.

### 6. Schedule Date Selection

- Status: Fixed
- Route: `/lich-chieu?date=30/04`
- Steps: Open schedule with `date=30/04`.
- Expected: Date state is reflected and booking links carry the selected date.
- Actual: Active date text is `30/04`; slot links include `date=30%2F04`.

### 7. Responsive Seat Page

- Status: Fixed
- Route: `/dat-ve/...`
- Steps: Resize to 390x844.
- Expected: No page-level horizontal overflow; seat map remains usable.
- Actual: Document scroll width stayed at 390, and the page showed the horizontal seat-map hint.

### 8. 404 State

- Status: Fixed
- Route: `/phim/not-a-real-movie`
- Steps: Open a missing movie URL.
- Expected: Branded 404 page, not a broken server error.
- Actual: Route returns HTTP 404.

### 9. Console And Network Errors

- Status: Mostly fixed
- Routes checked: movie detail, booking page, movies empty search, schedule.
- Expected: No user-facing console/network blockers.
- Actual: After the booking page patch, Playwright reported no console errors on the booking page. Vite is responding at `/@vite/client`.

## Verification Commands

- `php -l app\Http\Controllers\BookingController.php`
- `php artisan test`
- `npm.cmd run build`
- HTTP checks for `/`, `/phim`, `/phim?tab=upcoming&q=zzzzzz&genre=`, `/lich-chieu`, `/lich-chieu?date=30/04`, `/phim/phi-phong-quy-mau-rung-thieng`, `/dat-ve/phi-phong-quy-mau-rung-thieng`, `/dang-nhap`, and `/phim/not-a-real-movie`.

## Remaining Notes

- Some text is still ASCII/Vietnamese without accents in backend feedback such as `Vui long chon ghe de tiep tuc.` and account status `Cho thanh toan`; this is polish, not a flow blocker.
- Payment remains intentionally out of scope.
- Admin features were not tested or changed.

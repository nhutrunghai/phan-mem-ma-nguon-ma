# Visual + Functional Test Report

Project tested: `D:\pmmnm\frontend`  
App URL: `http://127.0.0.1:8000`  
Test date: 2026-05-05  
Tester role: Visual + Functional Tester Agent  
Scope: public customer-facing flows only. Admin flows were not tested.

## Test Method

- Browser testing with Playwright against the running local app.
- Desktop viewport: `1280x720`.
- Mobile viewport: `390x844`.
- Demo auth tested from `/dang-nhap` using `member@betacinemas.vn` with a non-empty password.
- Routes covered: `/`, `/phim`, `/phim?tab=upcoming&q=zzzzzz&genre=`, `/lich-chieu`, `/phim/phi-phong-quy-mau-rung-thieng`, `/dat-ve/phi-phong-quy-mau-rung-thieng`, `/dang-nhap`, `/tai-khoan`, and an invalid movie route.

## Confirmed Issues

### 1. Movie detail booking CTAs do not start the booking flow

Severity: Critical  
Page/route: `/phim/phi-phong-quy-mau-rung-thieng`  
Steps to reproduce:
1. Open `/phim/phi-phong-quy-mau-rung-thieng`.
2. Click the main buy-now CTA (`MUA VE NGAY`).
3. Click a visible showtime such as `15:45`.

Expected result: The customer is taken to seat selection or a booking/showtime modal opens with a clear next step.

Actual result: The main buy-now CTA leaves the user on the same page with no visible feedback. Clicking `15:45` also leaves the user on the same page with no booking transition.

Visual/UI notes: The controls look clickable and are styled as primary booking actions, so the lack of response is misleading.

Suggested fix: Connect the primary CTA and showtime buttons to the same booking route used by `/dat-ve/{id}`, passing the selected date/time/format, or open a functional booking modal that continues to seat selection.

### 2. Seat selection cannot select seats, so checkout is blocked

Severity: Critical  
Page/route: `/dat-ve/phi-phong-quy-mau-rung-thieng`  
Steps to reproduce:
1. Open `/dat-ve/phi-phong-quy-mau-rung-thieng` while logged in.
2. Click an available seat such as `B1` or `A1`.
3. Check the selected-seat summary, total, and continue button.

Expected result: The clicked seat changes to selected, the summary shows the seat code, total updates to `50.000 vnd`, and the continue button becomes enabled.

Actual result: The seat remains available, summary stays at the no-seat-selected state, total stays `0 vnd`, and the continue button remains disabled.

Visual/UI notes: Seat buttons show a pointer cursor and appear interactive, but no state change is visible after clicking.

Suggested fix: Verify the seat click listener is attached after the final seat DOM renders, and ensure CSS/overlay elements are not intercepting clicks. Add an end-to-end test that clicks a seat and asserts the hidden `seats` input, total, and continue button state update.

### 3. Movie and schedule filter submit buttons do not submit from normal clicks

Severity: High  
Page/route: `/phim`, `/lich-chieu`  
Steps to reproduce:
1. Open `/phim`.
2. Type `zzzzzz` in the movie-name search field.
3. Click the filter button.
4. Repeat the same steps on `/lich-chieu`.

Expected result: The page reloads with query parameters such as `?tab=upcoming&q=zzzzzz&genre=` and shows the empty state when nothing matches.

Actual result: The URL remains unchanged and the movie/schedule list remains visible. Directly opening `/phim?tab=upcoming&q=zzzzzz&genre=` does show the no-matching-movies empty state, so the backend empty state exists but the normal button flow is not working in the browser.

Visual/UI notes: The filters are visible and laid out correctly on desktop and mobile, but the primary action appears inert.

Suggested fix: Check whether front-end JavaScript prevents form submission or whether the button click is being intercepted. Keep the existing GET form behavior and add browser coverage for clicking the filter button.

### 4. Schedule date selector only changes visual state

Severity: High  
Page/route: `/lich-chieu`  
Steps to reproduce:
1. Open `/lich-chieu`.
2. Click a different date, for example `30/04`.
3. Observe the URL and listed showtimes.

Expected result: The selected date should update the schedule list or navigate with a date parameter.

Actual result: The route remains `/lich-chieu`; the visible schedule content does not refresh.

Visual/UI notes: The date pills look interactive and one becomes active, but the movie/showtime list does not reflect a date change.

Suggested fix: Make date buttons links/forms with a date query parameter, or wire them to switch date-specific schedule panels. Ensure showtime links use the selected date, not always the first date.

### 5. Showtime date text contains a doubled slash

Severity: Medium  
Page/route: `/phim/phi-phong-quy-mau-rung-thieng`  
Steps to reproduce:
1. Open `/phim/phi-phong-quy-mau-rung-thieng`.
2. View late showtime buttons such as `22:30` and `23:55`.

Expected result: Date text should render as `29/04`.

Actual result: Date text renders as `29//04`.

Visual/UI notes: The doubled slash appears inside compact showtime buttons and makes the schedule data look malformed.

Suggested fix: Normalize the label/suffix concatenation so the slash is added only once.

### 6. Auth page opens with a blocking cinema selector modal

Severity: Medium  
Page/route: `/dang-nhap`  
Steps to reproduce:
1. Open `/dang-nhap`.
2. Observe the page before interacting with the login form.

Expected result: The login/register form should be immediately usable, or a cinema selector should be optional and non-blocking.

Actual result: A cinema selector dialog opens over the auth form. The user must close it before using login/register fields.

Visual/UI notes: The modal includes a close button and city/cinema fields, but it interrupts a core auth flow.

Suggested fix: Do not auto-open the cinema selector on auth pages, or persist dismissal/selection before showing it again.

### 7. Auth and booking pages load broken production/static assets

Severity: Medium  
Page/route: `/dang-nhap`, `/dat-ve/phi-phong-quy-mau-rung-thieng`  
Steps to reproduce:
1. Open `/dang-nhap`.
2. Open browser console.
3. Repeat on `/dat-ve/phi-phong-quy-mau-rung-thieng`.

Expected result: Public pages should load without console/network errors for required assets.

Actual result: Console shows repeated failed resources, including CAPTCHA images from `https://betacinemas.vn/CreateCapcha*.jpg`, blocked `https://betacinemas.vn/manifest.html`, local 404s for `www.googletagmanager.com/...`, `connect.facebook.net/en_US/sdk.js`, `/assets/frontend/layout/img/up.png`, and `/cdn-cgi/rum?`.

Visual/UI notes: CAPTCHA-related failures affect auth reliability; the missing back-to-top image leaves a broken image in the floating control.

Suggested fix: Replace production absolute URLs with local/proxied assets for development, remove copied Cloudflare/GTM paths that are not served locally, and include the missing `up.png` asset or disable the control.

### 8. Mobile home header overlaps the carousel area

Severity: Medium  
Page/route: `/` at `390x844`  
Steps to reproduce:
1. Resize browser to `390x844`.
2. Open `/`.
3. Inspect the header/navigation and the hero carousel.

Expected result: The stacked mobile header/nav should reserve enough vertical space before the carousel begins.

Actual result: The navigation wraps into multiple rows but the main carousel still starts at the desktop header offset, causing the nav area to overlap the carousel.

Visual/UI notes: On mobile, navigation links extend down to about `218px`, while the main carousel starts at about `117px`.

Suggested fix: Adjust the home page mobile header/main spacing so the content starts below the wrapped nav, consistent with `/phim` where the main content starts lower.

### 9. Invalid public movie URLs show an unbranded default 404

Severity: Low  
Page/route: `/phim/not-a-real-movie`  
Steps to reproduce:
1. Open `/phim/not-a-real-movie`.

Expected result: A branded public error page with navigation back to movies/home.

Actual result: The page shows only default `404 | Not Found` text.

Visual/UI notes: No site header, footer, or recovery action is shown.

Suggested fix: Add a branded Laravel 404 view for public routes with links back to `/phim` and `/`.

## Tested Flows With No Confirmed Issue

- Home page loads on desktop with carousel controls, movie tabs, movie cards, and footer content visible.
- Movie list tabs navigate between `/phim?tab=upcoming`, `/phim?tab=now-showing`, and `/phim?tab=special`.
- Direct movie-list empty state works when visiting `/phim?tab=upcoming&q=zzzzzz&genre=`.
- Demo login through `/dang-nhap` works after closing the cinema selector; it redirects to `/tai-khoan` and shows the logged-in account page.
- Logged-in header state shows `Member` and logout.
- Account page renders account details and the update-account button.
- Mobile `/phim` layout stacks filters, tabs, and movie cards without horizontal overflow in the tested viewport.

## Coverage Notes

- Payment completion could not be tested because seat selection never enabled the continue button.
- Admin pages were not tested.
- No source code was changed as part of this test pass.

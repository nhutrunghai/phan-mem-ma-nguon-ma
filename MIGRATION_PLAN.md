# Migration Plan

## Scope And Ground Rules

Current project: `D:\pmmnm\frontend`.

Reference old source: `D:\pmmnm\web_mua_ve_phim_2`.

This plan treats the current SSR Laravel/Vite UI as the source of truth. The old source should be used as a domain reference for user-facing cinema features only. Admin features, admin users, back-office CRUD, and direct cloning of old presentation code are out of scope.

Do not blindly copy old logic. The old source contains useful domain concepts, but several implementation details are prototype-level: hard-coded seat maps, implicit database record creation during booking, demo/static data fallbacks, incomplete payment return wiring, and duplicated imported assets.

## Current Project Snapshot

The current project is a Laravel 12 SSR Blade application with Vite present but most user-facing pages rendered through Blade and public assets.

Useful current files:

- `routes/web.php`: contains route closures for home, schedule, movie list/detail, static pages, demo auth, account, and static seat selection.
- `resources/views/layouts/app.blade.php`: main SSR shell, header/footer includes, Beta asset CSS/JS imports, member/account styling.
- `resources/views/home.blade.php`: current home UI.
- `resources/views/movies.blade.php`: current movie listing UI.
- `resources/views/movie-detail.blade.php`: current movie detail UI.
- `resources/views/schedule.blade.php`: current schedule UI.
- `resources/views/seat-selection-content.blade.php`: current seat map UI and client-side selection behavior.
- `resources/views/account.blade.php`: current member/account UI with profile, history, points, password tabs using demo data.
- `resources/views/auth.blade.php`: current auth page shell if auth is retained as SSR page.
- `resources/views/partials/header.blade.php` and `resources/views/partials/footer.blade.php`: current navigation and footer source of truth.
- `resources/data/web-home.json`: static site/movie/navigation/footer data currently driving the SSR pages.
- `public/web-home/assets/*` and `public/beta-mirror/*`: current visual assets and imported legacy Beta assets.

Current user-facing features:

- Home page with hero, movie tabs, movie cards, and footer content.
- Schedule page derived from static JSON/default schedule groups.
- Movie listing with tabs.
- Movie detail page with trailer, metadata, and showtime links.
- Seat selection demo page with fixed row map, selected/held/sold/reserved states, timer, and sidebar summary.
- Static tracker-import pages for cinema info, prices, promotions, franchise.
- Demo login/register/account flow using session data, not persisted users.
- Member profile/history/points/password tabs using mostly static/demo data.

Current backend/database state:

- Composer has `laravel/framework` and no MongoDB dependency.
- Default Laravel migrations exist for SQL users/cache/jobs.
- Only `app\Models\User.php` exists in current project.
- No current booking, payment, cinema, movie, room, seat, showtime, notification models.
- Current route logic relies heavily on closure functions and `resources/data/web-home.json`.

## Old Source Snapshot

The old source is also Laravel 12, but adds MongoDB-backed domain models, real auth controller actions, booking/payment controller actions, user notifications, booking history/detail/print pages, and a Mongo import command.

Useful old files:

- `app/Http/Controllers/AuthController.php`: login, register, logout, forgot password, profile update, password change.
- `app/Http/Controllers/BookingController.php`: seat page, booking creation, booking detail/history, notifications, payment page, payment confirmation, payment return/IPN helpers, cancel, print ticket.
- `app/Services/MovieCatalog.php`: reads `resources/data/web-home.json` and finds movies.
- `app/Services/PaymentGatewayService.php`: internal/MoMo/VNPay URL creation and callback verification.
- `config/payment-gateways.php`: payment gateway env config.
- `app/Models/Movie.php`, `Cinema.php`, `Room.php`, `Seat.php`, `Showtime.php`, `Booking.php`, `BookingSeat.php`, `Payment.php`, `UserNotification.php`, `User.php`: MongoDB document models.
- `app/Console/Commands/ImportSiteDataToMongo.php`: imports JSON data to MongoDB collections and creates sample cinema/room/seat/showtime/user data.
- `resources/views/booking-detail.blade.php`: e-ticket detail with QR code.
- `resources/views/payment-page.blade.php`: payment selection/fallback simulation page.
- `resources/views/ticket-print.blade.php`: printable ticket view.
- `resources/views/booking-history.blade.php`: booking history page.
- `resources/views/user-notifications.blade.php`: user notifications page.
- `resources/views/static-page.blade.php`: SSR replacement for old static tracker pages.
- `resources/views/account.blade.php`: real-account version of current member tabs.
- `resources/views/auth.blade.php`: SSR auth forms.

Old source user-facing features:

- Real email/password registration and login.
- Authenticated account profile update.
- Password change and forgot-password request.
- Booking creation from selected seats.
- Sold-seat conflict check against prior bookings.
- Booking history and booking detail pages.
- QR/e-ticket display and printable ticket.
- Payment page with internal simulation when gateways are not configured.
- MoMo and VNPay payment URL generation when env keys exist.
- User notifications for booking/payment/cancel events.
- Schedule/movie search and genre filtering.
- Static placeholder pages for cinema info, ticket prices, promotions, and franchise instead of raw tracker HTML.

Old source database structure:

- `users`: `full_name`, `email`, `password`, `phone`, `birthday`, `gender`, `avatar`, `role`, `status`.
- `movies`: `title`, `description`, `duration`, `genre`, `director`, `cast`, `language`, `release_date`, `poster`, `trailer`, `age_rating`, `status`.
- `cinemas`: `name`, `address`, `city`.
- `rooms`: `cinema_id`, `name`, `total_seats`.
- `seats`: `room_id`, `seat_number`, `seat_type`.
- `showtimes`: `movie_id`, `room_id`, `start_time`, `end_time`, `price`.
- `bookings`: `user_id`, `showtime_id`, `total_price`, `payment_status`, `booking_status`, `qr_code`.
- `booking_seats`: `booking_id`, `seat_id`, `price`.
- `payments`: `booking_id`, `method`, `amount`, `transaction_code`, `payment_date`, `status`.
- `notifications`: `user_id`, `title`, `message`, `type`, `read_at`.

Important note: the old source implements these as MongoDB models using `mongodb/laravel-mongodb`. The current project does not include that package, so the migration must first choose whether to keep the current SQL/Laravel migration path or intentionally add MongoDB. For a Laravel SSR app, SQL migrations are the more maintainable default unless the project already requires MongoDB.

## Reuse, Adapt, Ignore, Improve

### Reuse

- Reuse the old domain model names and relationships as the starting conceptual schema: movie, cinema, room, seat, showtime, booking, booking seat, payment, notification.
- Reuse `AuthController` behavior at the feature level: login, register, logout, forgot password request, profile update, password change.
- Reuse `BookingController` feature flow at the level of user journeys: show seat availability, post selected seats, create booking, detect conflicts, show ticket detail, show history, cancel booking, print ticket.
- Reuse `PaymentGatewayService` as a reference for MoMo/VNPay parameter structure, env-driven enablement, and signature verification.
- Reuse the idea of `MovieCatalog` as a temporary bridge from JSON to models during migration.
- Reuse `static-page.blade.php` concept to replace imported tracker pages with SSR pages that use current layout/header/footer.
- Reuse old booking detail, payment page, print ticket, booking history, and notification views only as content/UX references.

### Adapt

- Adapt old MongoDB models into Laravel SQL Eloquent models and migrations unless MongoDB is explicitly required. Use `id` foreign keys, indexes, constraints, and transactions.
- Adapt route closures in current `routes/web.php` into controllers gradually. Avoid expanding the current monolithic route file further.
- Adapt old account/auth views into the current layout and styling. Preserve the current account visual structure, fields, tabs, header/footer, and CSS language.
- Adapt current `seat-selection-content.blade.php` to submit a real POST while preserving its existing UI. The old source made the button a form submit and hidden seat input; that behavior is reusable, but the current styling/held-seat UX should stay.
- Adapt movie data flow from `resources/data/web-home.json` to database-backed queries in phases. Do not remove JSON immediately; use it as seed/import source and fallback until DB data is complete.
- Adapt payment return/IPN routes to call controller/service verification. The old route definitions currently use placeholder closures for return/IPN even though `BookingController` has verification methods.
- Adapt old notification table into member/account notifications tab or header badge, not a separate visual system.
- Adapt old booking history data to current account history tab, adding links to ticket detail.
- Adapt imported static content into first-class Blade sections rather than continuing to wrap full external HTML through `tracker-import`.

### Ignore

- Ignore admin user creation in `ImportSiteDataToMongo.php`; admin features are out of scope.
- Ignore old raw tracker HTML wrapping as a long-term architecture. It is useful only as a temporary content source.
- Ignore direct MongoDB package/config unless the product requirement explicitly chooses MongoDB.
- Ignore hard-coded prototype defaults as final behavior: fixed `50000` ticket price, `Beta Thai Nguyen` default, fixed seat rows, preselected seats, reserved seats, and implicit room/showtime creation.
- Ignore duplicated `public/beta-mirror/Assets/assets/...` copies unless an asset is still referenced by current UI.
- Ignore old demo auth/session routes as final behavior once real auth is implemented.

### Improve

- Add proper transactional booking creation with row-level or application locks to prevent double booking.
- Add explicit seat status lifecycle: available, held, booked/sold, unavailable/reserved. The old code only checks booked seats after selection and does not implement real temporary holds.
- Add authorization checks everywhere a booking, payment, print ticket, or notification is accessed. The old `detail()` JSON method does not check ownership.
- Add normalized price handling: showtime base price plus seat-type adjustment, not a single hard-coded amount.
- Add real payment state transitions: pending, pending_gateway, paid, failed, expired, refunded/cancelled if needed.
- Add gateway callback routes that verify signatures and update payment/booking idempotently.
- Add indexes: `showtimes(movie_id, room_id, start_time)`, `seats(room_id, seat_number)`, `bookings(user_id, created_at)`, `booking_seats(booking_id)`, and a uniqueness strategy preventing duplicate booked seat per showtime.
- Add tests around auth, booking conflict, payment fallback, payment callback verification, account authorization, and route rendering.
- Fix text encoding before migrating static content. Many current and old strings appear mojibake-encoded; do not propagate broken text into database seed data.

## Recommended Target Architecture

Use the current app as a server-rendered Laravel app with Blade pages and Vite for compiled CSS/JS where needed.

Recommended layers:

- Controllers: `MovieController`, `ScheduleController`, `AuthController`, `AccountController`, `BookingController`, `PaymentController`, `StaticPageController`.
- Services: `MovieCatalogImporter` or `MovieCatalog`, `SeatAvailabilityService`, `BookingService`, `PaymentGatewayService`, `NotificationService`.
- Models: `User`, `Movie`, `Cinema`, `Room`, `Seat`, `Showtime`, `Booking`, `BookingSeat`, `Payment`, `UserNotification`.
- Views: keep current pages and add missing booking/payment/ticket views inside current `layouts.app`.
- Routes: keep public routes stable: `/`, `/lich-chieu`, `/phim`, `/phim/{id}`, `/dat-ve/{id}`, `/thanh-toan/{booking}`, `/ve/{booking}`, `/ve/{booking}/in`, `/tai-khoan`, `/auth/login`, `/auth/register`, `/auth/logout`.

Database recommendation:

- Prefer SQL migrations in current project because it already ships with Laravel SQL migrations and no MongoDB dependency.
- If MongoDB is mandated, add `mongodb/laravel-mongodb`, copy old connection config intentionally, and document deployment requirements. Do not mix SQL users and Mongo domain records without a clear integration plan.

## Migration Phases

### Phase 1: Stabilize Current UI And Routing

Goal: preserve the current UI while preparing backend seams.

- Extract large route closure helpers from `routes/web.php` into services/controllers without changing rendered output.
- Keep current Blade files as source of truth for home, movies, movie detail, schedule, account, and seat selection.
- Add route names that match user journeys rather than old demo route names.
- Replace raw tracker-import usage for static pages with current-layout Blade pages where feasible.
- Keep `resources/data/web-home.json` as the data source during this phase.

Deliverables:

- Controller/service skeletons.
- No visual regression on public pages.
- Route tests for existing public pages.

### Phase 2: Introduce Real Auth And Account Persistence

Goal: replace demo session account with real Laravel authentication.

- Adapt old `AuthController` actions into current project.
- Extend current `User` model/migration to support `full_name`, `phone`, `birthday`, `gender`, `avatar`, `status`; avoid `role` unless needed outside admin scope.
- Convert current account form fields to POST to profile/password endpoints while preserving current layout.
- Replace demo login/register redirect logic with real `/auth/login` and `/auth/register` routes.
- Preserve old `/dang-nhap`, `/dang-ky`, `/tai-khoan`, `/thanh-vien` as compatibility redirects if current links depend on them.

Avoid:

- Do not copy old auth view wholesale if it changes the current visual design.
- Do not keep both demo-user session and real auth as parallel production paths.

### Phase 3: Persist Movie, Cinema, Room, Seat, Showtime Data

Goal: move from static JSON schedule/movie data to database-backed content.

- Create migrations/models for movies, cinemas, rooms, seats, and showtimes.
- Build an importer from `resources/data/web-home.json` based on the old `ImportSiteDataToMongo.php`, but without admin creation and without destructive deletes by default.
- Map old JSON fields carefully:
  - `id`/slug should become a stable movie slug.
  - `title`, `description`, `duration`, `genre`, `language`, `poster`, `trailer`, `label` become movie fields.
  - `details` can feed `director`, `cast`, and display metadata.
  - `scheduleDates`, `showtimeGroups`, and `scheduleByDate` should become normalized showtimes where possible.
- Keep JSON fallback until the DB has equivalent data.

Avoid:

- Do not create missing movies/showtimes implicitly during booking as the old `resolveShowtime()` does.
- Do not store date strings like `01/05/2026` as primary schedule data; use proper datetimes and format them in views.

### Phase 4: Real Seat Selection And Booking

Goal: turn current seat UI into a real booking flow.

- Keep current `resources/views/seat-selection-content.blade.php` styling and component structure.
- Add a POST form or AJAX endpoint that submits `showtime_id` and selected seat ids/codes.
- Compute sold seats from existing paid/booked bookings.
- Add temporary hold support if expected by UI. The current UI already distinguishes held seats; backend should model this instead of hard-coding `heldSeats`.
- Create booking and booking seats in a database transaction.
- Prevent double booking with a uniqueness or locking strategy.
- Redirect to ticket detail or payment page after booking creation.

Adapt from old source:

- Use old `store()` flow as a behavior reference.
- Use old conflict check concept, but implement it with SQL joins/indexes and a transaction.
- Use old hidden seat input concept if staying with standard form submission.

Improve over old source:

- Require a real authenticated user or a deliberate guest checkout model.
- Do not use `auth()->id() ?? session('demo_user.email')`.
- Do not auto-create cinema/room/seat/showtime records while booking.
- Do not preselect seats by default unless explicitly passed by user action.

### Phase 5: Ticket Detail, History, Notifications, Print

Goal: surface completed bookings in current account UI.

- Add booking history to current account history tab.
- Add notification tab or panel while preserving current member layout.
- Add ticket detail page with QR code, movie/cinema/room/showtime/seat/payment status.
- Add print ticket page using current layout or a print-specific minimal layout.
- Generate QR data internally, ideally containing booking id plus signed token or opaque ticket code.

Adapt from old source:

- Use `booking-detail.blade.php`, `ticket-print.blade.php`, `booking-history.blade.php`, and `user-notifications.blade.php` as content references.
- Use `UserNotification` concept for booking created, payment success, cancellation, and expiration.

Improve over old source:

- Enforce ownership checks on all booking/ticket/notification pages.
- Make payment and booking statuses user-friendly in Vietnamese at the view layer instead of rendering raw status codes.
- Store enough denormalized snapshot data on booking if movie/showtime metadata can change later.

### Phase 6: Payment Integration

Goal: support internal test payment first, then MoMo/VNPay safely.

- Add `config/payment-gateways.php` adapted from the old source.
- Add `PaymentGatewayService`, but split gateway-specific code if it grows.
- Implement internal test payment in non-production or behind config.
- Implement MoMo and VNPay creation only after env values are configured.
- Wire return/IPN routes to verification methods, not placeholder closures.
- Make callback handling idempotent: repeated callbacks must not create duplicate successful payments or corrupt booking status.

Adapt from old source:

- Reuse env-driven enablement and signing logic as a starting point.
- Reuse method names conceptually: create URL, verify return, extract booking id.

Improve over old source:

- Validate gateway response codes, not only signatures.
- Persist gateway request id/order id/transaction reference.
- Handle payment failed/cancelled/expired.
- Do not show direct gateway links generated on GET if doing so creates remote payment sessions repeatedly. Prefer POST create-payment action.

## Route Mapping

Recommended route evolution:

- `GET /`: keep current home.
- `GET /lich-chieu`: current schedule UI, later DB-backed filters.
- `GET /phim`: current movie list UI, add query search/genre filter if desired.
- `GET /phim/{id}`: current movie detail UI, migrate `{id}` to slug.
- `GET /dat-ve/{id}`: current seat UI, but resolve a real showtime.
- `POST /dat-ve/{id}` or `POST /bookings`: create booking from selected seats.
- `GET /ve/{booking}`: ticket/booking detail.
- `GET /ve/{booking}/in`: print ticket.
- `POST /ve/{booking}/huy`: cancel booking if policy allows.
- `GET /thanh-toan/{booking}`: payment page.
- `POST /thanh-toan/{booking}`: create internal/gateway payment.
- `GET /thanh-toan/return/{gateway}`: verified gateway return.
- `POST /thanh-toan/ipn/{gateway}`: verified gateway IPN/webhook.
- `GET /auth/login`, `POST /auth/login`: real login.
- `GET /auth/register`, `POST /auth/register`: real registration.
- `POST /auth/logout`: real logout.
- `GET /auth/account`: account page, or keep `/tai-khoan` as the canonical localized URL.
- `POST /auth/account/profile`: profile update.
- `POST /auth/account/password`: password update.

Compatibility redirects:

- `/dang-nhap` -> `/auth/login`.
- `/dang-ky` -> `/auth/register`.
- `/thanh-vien` -> account when authenticated, login otherwise.
- `/tai-khoan` -> account route.

## Data Model Notes For SQL Implementation

Suggested SQL tables:

- `movies`: `id`, `slug`, `title`, `description`, `duration_minutes`, `genre`, `director`, `cast` JSON/text, `language`, `release_date`, `poster_url`, `trailer_url`, `age_rating`, `status`, timestamps.
- `cinemas`: `id`, `name`, `address`, `city`, `phone`, timestamps.
- `rooms`: `id`, `cinema_id`, `name`, `total_seats`, timestamps.
- `seats`: `id`, `room_id`, `seat_code`, `seat_type`, `row_label`, `seat_number`, `status`, timestamps.
- `showtimes`: `id`, `movie_id`, `room_id`, `starts_at`, `ends_at`, `format`, `base_price`, `status`, timestamps.
- `bookings`: `id`, `user_id`, `showtime_id`, `ticket_code`, `total_price`, `payment_status`, `booking_status`, `expires_at`, timestamps.
- `booking_seats`: `id`, `booking_id`, `seat_id`, `showtime_id`, `price`, timestamps.
- `payments`: `id`, `booking_id`, `method`, `amount`, `transaction_code`, `gateway_order_id`, `gateway_payload` JSON, `paid_at`, `status`, timestamps.
- `user_notifications`: `id`, `user_id`, `title`, `message`, `type`, `read_at`, timestamps.

Recommended constraints/indexes:

- Unique `movies.slug`.
- Unique `seats(room_id, seat_code)`.
- Index `showtimes(movie_id, starts_at)`.
- Index `showtimes(room_id, starts_at)`.
- Index `bookings(user_id, created_at)`.
- Unique active booking-seat protection. In SQL this may need a dedicated `seat_locks`/`showtime_seats` table or transaction logic because uniqueness across only non-cancelled bookings is database-specific.

## Known Risks In Old Source

- Payment return/IPN routes in `routes/web.php` are placeholders and do not call `BookingController::paymentReturn()` or `paymentIpn()`.
- `BookingController::detail()` returns booking JSON with no ownership check.
- `resolveShowtime()` searches `Movie` by `title = $movieId`, then creates records if missing; this can create bad production data.
- Sold-seat checks are not wrapped in a transaction, so concurrent requests can double-book seats.
- Seat rows, prices, reserved seats, held seats, and preselected seats are hard-coded.
- Booking history view expects fields like `movie_title`, `cinema`, `show_date`, `show_time`, but old `Booking` model does not fill those fields.
- Old `AuthController::updateProfile()` fills `name`, but old `User` model uses `full_name`; this mismatch should be fixed during adaptation.
- Old `ImportSiteDataToMongo.php` destructively deletes data and creates an admin user; do not use as-is.
- QR code uses a public QR API URL. Prefer local QR generation or signed ticket URLs if production privacy matters.
- Text encoding is already broken in many strings. Migrate content after fixing source encoding, not after copying mojibake.

## Suggested Implementation Order

1. Add SQL migrations/models for real users/profile fields and booking domain tables.
2. Add controllers/services without changing current UI output.
3. Replace demo auth with real auth while preserving current account/auth pages.
4. Build JSON-to-database importer/seed command for movies/cinemas/showtimes/seats.
5. Convert schedule/movie detail to DB-backed data with JSON fallback.
6. Convert seat selection to real POST booking creation.
7. Add booking detail/history/print views into current layout.
8. Add internal payment simulation.
9. Add gateway config/service and verified MoMo/VNPay callbacks.
10. Remove obsolete demo routes/data fallbacks only after equivalent persisted flows are tested.

## Minimum Test Plan

- Public pages render: home, schedule, movies, movie detail, static pages.
- Registration creates user and logs in.
- Login/logout works and regenerates sessions.
- Profile update persists expected fields.
- Password change validates current password.
- Seat page renders sold/held/booked states from backend data.
- Booking creation stores booking and booking seats with correct total.
- Duplicate seat booking is rejected.
- User cannot view/cancel/print another user's booking.
- Booking history shows current user's bookings.
- Payment simulation marks booking paid and creates payment.
- Payment callback verification rejects invalid signatures.
- Payment callback is idempotent.


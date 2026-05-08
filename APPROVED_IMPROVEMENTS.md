# Approved Improvements

Gatekeeper review for `D:\pmmnm\frontend` against reference source `D:\pmmnm\web_mua_ve_phim_2`.

## Review Status

- `PRODUCT_NOTES.md` was not present in `D:\pmmnm\frontend`.
- The current frontend git worktree is clean at review time.
- No application code changes were made during this review.
- This approval is limited to frontend/demo improvements that preserve the current UI structure and avoid importing old backend scope.

## Approved Safe Improvements

The following improvement categories are approved because they are useful, low risk, and consistent with the current frontend project:

- Preserve the existing Blade page structure for home, movie listing, movie detail, schedule, account/demo auth, and seat-selection screens.
- Keep using `resources/data/web-home.json` as static/demo content input for frontend rendering.
- Keep route-level demo pages and route remapping that replaces legacy `.php` links with Laravel routes or safe `#` placeholders.
- Keep demo login/register/logout behavior only as a frontend/session demo, without adding real account persistence unless separately scoped.
- Keep the current visual asset mirror under `public/beta-mirror` and curated frontend assets under `public/web-home`, as long as new work does not blindly bulk-import old source files.
- Keep seat-selection as a UI/demo flow with static seat state and client-side selection behavior.
- Continue small UI fixes that improve responsiveness, navigation consistency, encoding display, form labels, accessibility attributes, and broken internal links.
- Continue extracting repeated view fragments into partials only when it reduces duplication without changing the visible layout.

## Not Approved

The following changes are not approved for this frontend scope:

- Do not copy backend booking/payment/auth logic from `D:\pmmnm\web_mua_ve_phim_2` into the current project.
- Do not add `BookingController`, `AuthController`, payment gateway services, MongoDB models, booking history, notification persistence, ticket printing, or cancellation flows unless a new backend implementation scope is explicitly approved.
- Do not implement admin features, admin users, dashboards, CRUD management, role/permission handling, or data import commands.
- Do not convert the current frontend into a full production booking system in this pass.
- Do not blindly copy legacy Blade, CSS, JavaScript, route, model, config, or asset directories from the old source.
- Do not add large dependencies, new frameworks, build systems, queues, databases, or service abstractions for simple static/demo UI requirements.

## Preliminary Concerns

- The reference old source contains real backend booking, payment, notification, MongoDB, and auth additions that exceed the current frontend/demo scope.
- The current `routes/web.php` contains a large amount of inline data and helper functions. This is acceptable for the current demo, but future work should avoid making it more complex; only extract helpers if that clearly improves maintainability.
- Some Vietnamese text appears mojibake-encoded in inline route data. Encoding cleanup is approved if it is limited, verified visually, and does not alter behavior.
- The project currently includes mirrored legacy assets. Future additions should be selective and justified, not bulk copied.

## Gatekeeping Criteria For Future Approval

A future change may be approved only if it satisfies all of these:

- It preserves the current public UI structure and Beta-style visual language.
- It is frontend/demo-focused and does not introduce production backend behavior.
- It replaces legacy links safely without breaking current routes.
- It avoids admin and management functionality.
- It is small enough to review and does not overcomplicate the Laravel frontend.
- It includes a clear reason for each imported asset or borrowed behavior from the old source.
- It can be verified with basic route/page checks.

## Post-Implementation Gate Update

After the later implementation pass, the following scoped backend additions are approved because they support real customer-facing booking behavior without copying old MongoDB/admin/payment code:

- SQL migrations and Eloquent models for movies, cinemas, rooms, seats, showtimes, bookings, and booking seats.
- A small `MovieCatalog` service that preserves the current JSON/tracker UI data as fallback and can overlay migrated DB records.
- `BookingController` for the existing `/dat-ve/{id}` flow, keeping the current seat-selection view while replacing hard-coded sold seats with persisted booking data.
- Seed data derived from current UI data, limited to public movie/showtime/seat demo content.
- Movie/schedule search and empty-state UI that preserves the current page structure.
- Account history display for the current demo user's persisted bookings.

Still not approved:

- Admin CRUD, dashboards, reporting, roles, or staff workflows.
- MoMo/VNPay/payment gateway work in this pass.
- Bulk-copying old views, MongoDB models, services, routes, or assets.
- Replacing the current UI layout with the old source UI.

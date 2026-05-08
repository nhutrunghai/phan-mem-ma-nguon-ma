# Product Notes: SSR Movie Ticket Booking UX

Scope: customer-facing SSR booking experience only. Admin features are out of scope. Preserve the current Beta Cinemas visual direction and do not copy the old source blindly; use it only as evidence of fuller booking/payment/history flows that may exist later.

## Current Read

The current frontend already has a recognizable movie discovery and booking path: home/movie list, movie detail with showtime modal, seat selection, account demo pages, and imported static informational pages. The highest-value UX work is not a redesign. It is small interaction feedback that makes the SSR flow feel trustworthy when the user clicks, waits, changes choices, or hits an error.

Most gaps are around state visibility:

- Several user actions change page state silently, such as schedule date selection and movie tab filtering.
- Booking confirmation exists, but the transition into seat selection does not show progress or prevent repeated clicks.
- Seat selection is visually present, but selected seats, unavailable seats, timer expiry, and the next-step outcome need clearer feedback.
- Account/profile buttons look actionable but do not clearly explain whether changes were saved.
- Current failure handling mostly depends on browser alerts, default redirects, or no visible message.

## Recommended Small Improvements

### 1. Toast notifications for lightweight feedback

Add a small top-right or bottom-right toast system that matches the current blue/orange Beta palette. Use it for non-blocking confirmations and recoverable warnings, not for critical decisions.

Suggested triggers:

- Login/register demo success: "Dang nhap thanh cong. Chao mung ban quay lai."
- Logout: "Ban da dang xuat."
- Account update/demo-only action: "Thong tin da duoc ghi nhan trong phien demo."
- Showtime date changed: "Dang hien thi suat chieu ngay 05/05."
- Seat selected/unselected: only toast for exceptions, not every click.
- Payment/booking return later: "Thanh toan thanh cong. Ve cua ban da san sang."

Acceptance criteria:

- Toasts auto-dismiss after 3-5 seconds.
- Error toasts stay longer and include a clear next action.
- Toasts should not shift layout or cover the booking CTA on mobile.

### 2. Loading states for booking transitions

Add obvious loading feedback when the user commits to a next step.

Recommended places:

- "DONG Y" in the booking modal: disable after first click and change label to "Dang giu suat..."
- "TIEP TUC" on seat selection: disable after click and show "Dang tao booking..."
- Payment gateway buttons later: disable and show "Dang chuyen sang MoMo/VNPay..."
- Movie cards and schedule slots: keep the current href behavior, but show a small inline spinner if JavaScript intercepts the click.

Why this matters:

- Booking is a high-anxiety flow where duplicate clicks can create duplicate holds or confusing redirects.
- SSR page transitions can feel frozen on slow connections without explicit feedback.

### 3. Empty states for no movies, showtimes, seats, or history

Add friendly empty states where lists can become empty after filtering, API/data changes, or future backend integration.

Recommended copy:

- Movie list: "Hien chua co phim trong muc nay. Vui long quay lai sau."
- Schedule page: "Chua co suat chieu cho ngay da chon. Thu chon ngay khac."
- Movie detail: "Phim nay chua mo ban ve online."
- Seat map: "So do ghe chua san sang. Vui long thu lai hoac chon suat chieu khac."
- Account history: "Ban chua co giao dich nao. Kham pha phim dang chieu de dat ve dau tien."

Acceptance criteria:

- Empty states include one clear recovery action, such as "Xem phim dang chieu" or "Chon ngay khac."
- Empty states should reuse existing typography and spacing rather than introducing a new illustration-heavy pattern.

### 4. Confirmation dialogs for irreversible or risky actions

Use confirmation dialogs sparingly for actions with real consequence.

Recommended confirmations:

- Leaving seat selection after choosing seats: "Ban dang giu ghe C6, C7. Roi trang se huy lua chon nay."
- Timer expiry: "Thoi gian giu ghe da het. Vui long chon lai ghe."
- Cancel booking later: "Ban chac chan muon huy ve nay? Ghe se duoc mo lai cho nguoi khac."
- Changing showtime after opening the booking modal: show the selected cinema/date/time clearly before confirming.

Avoid confirmations for:

- Switching movie tabs.
- Opening/closing the trailer.
- Selecting or unselecting a normal seat.

### 5. Booking progress feedback

Add a compact progress indicator to the booking flow without changing the page layout.

Suggested steps:

1. Chon suat
2. Chon ghe
3. Thanh toan
4. Nhan ve

Current implementation can highlight only the first two steps for now. If payment is not implemented in this frontend yet, label the next step honestly as "Thanh toan - sap co" or route to a clear placeholder instead of using an alert.

Seat page additions:

- Show "Dang giu ghe trong 10:00" near the countdown.
- When below 2 minutes, add helper copy: "Sap het thoi gian giu ghe."
- At 0:00, disable seat actions and provide "Chon lai suat chieu."

### 6. Clearer seat selection state

The seat map is the most important interaction surface. Keep the current visual style, but clarify meaning and outcome.

Recommended adjustments:

- Use distinct colors for selected seats versus sold seats. At the moment selected and sold seats both read as red in CSS, which can confuse users.
- Add `aria-pressed` for selectable seats and `aria-label` values like "Ghe C7, dang chon" or "Ghe D5, da ban."
- Show selected seat count beside the seat list: "6 ghe da chon."
- Replace "0 vnd" total with real calculated pricing or a clear temporary label: "Gia ve dang cap nhat."
- If preselected seats are demo data, add a small note: "Ghe mau dang duoc chon san cho ban demo."
- When clicking a held/sold/reserved seat, show a toast explaining why it cannot be selected.

Suggested unavailable-seat copy:

- Sold: "Ghe D5 da ban. Vui long chon ghe khac."
- Held: "Ghe E4 dang duoc giu boi khach khac."
- Reserved: "Ghe H3 dang duoc dat truoc."

### 7. Better error messages

Replace generic alerts and silent failures with specific, user-actionable copy.

Recommended patterns:

- Validation: "Vui long nhap email hop le, vi du name@example.com."
- Auth/demo limitation: "Tinh nang nay dang o che do demo. Thong tin chua duoc luu vao tai khoan that."
- Seat conflict: "Ghe C6 vua duoc nguoi khac dat. Chung toi da bo ghe nay khoi lua chon cua ban."
- Network/server issue: "Khong the tai du lieu suat chieu. Kiem tra ket noi va thu lai."
- Payment return issue later: "Chua xac nhan duoc thanh toan. Neu ban da bi tru tien, vui long lien he hotline kem ma ve."

Acceptance criteria:

- Error messages state what happened and what the user can do next.
- Do not expose backend terms such as exception, invalid payload, stack trace, gateway signature, or database ID.
- Use Vietnamese copy consistently for user-facing states.

## Priority Order

1. Seat selection clarity: selected vs sold color, count, unavailable-seat feedback, timer expiry behavior.
2. Loading states: modal confirm, continue button, future payment buttons.
3. Toast system: success/error/warning feedback across auth, account, booking, and payment return.
4. Empty states: movie tabs, showtime panels, booking history, seat map failure.
5. Confirmation dialogs: leaving selected seats, timer expiry, future booking cancellation.
6. Error copy cleanup: replace browser alerts and generic messages with contextual text.

## Not Recommended Now

- Do not redesign the home page, header, movie cards, or footer.
- Do not import the old source's full payment/history implementation into this frontend just for parity.
- Do not add admin UX, staff workflows, room management, or reporting.
- Do not add heavy animations, large illustrations, or a new design system.
- Do not make every click show a toast; use feedback only where it reduces uncertainty.

## Product Success Signals

- Users can tell what step they are in and what happens after the next CTA.
- Users understand why a seat cannot be selected.
- Users never wonder whether a click worked during booking or payment transitions.
- Empty or demo-only states feel intentional rather than broken.
- Errors explain recovery steps without technical language.

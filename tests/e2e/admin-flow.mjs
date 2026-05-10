import playwright from '../../../web_mua_ve_phim_2/node_modules/playwright/index.js';

const { chromium } = playwright;

const baseURL = process.env.ADMIN_BASE_URL || 'http://127.0.0.1:8011';
const adminEmail = process.env.ADMIN_EMAIL || 'admin@example.com';
const adminPassword = process.env.ADMIN_PASSWORD || 'password';

function assert(condition, message) {
  if (!condition) {
    throw new Error(message);
  }
}

async function expectText(page, text, message = `Missing text: ${text}`) {
  await page.getByText(text, { exact: false }).first().waitFor({ timeout: 7000 });
  assert(await page.getByText(text, { exact: false }).first().isVisible(), message);
}

async function firstCount(locator) {
  return await locator.count();
}

async function clickFirst(page, selector) {
  const locator = page.locator(selector).first();
  await locator.waitFor({ timeout: 7000 });
  await locator.click();
}

async function submitAndWait(page, action) {
  await Promise.all([
    page.waitForLoadState('networkidle').catch(() => {}),
    action(),
  ]);
}

const browser = await chromium.launch({ headless: true });
const context = await browser.newContext();
const page = await context.newPage();
const errors = [];

page.on('pageerror', error => errors.push(`pageerror: ${error.message}`));
page.on('console', message => {
  if (message.type() === 'error') {
    errors.push(`console error: ${message.text()}`);
  }
});

try {
  console.log('1. Kiểm tra đăng nhập sai/đúng');
  await page.goto(`${baseURL}/admin/login`, { waitUntil: 'networkidle' });
  await expectText(page, 'Đăng nhập quản trị');
  await page.fill('input[name="email"]', 'wrong@example.com');
  await page.fill('input[name="password"]', 'wrong-password');
  await submitAndWait(page, () => page.locator('button[type="submit"]').click());
  await expectText(page, 'Thông tin đăng nhập quản trị không đúng');

  await page.fill('input[name="email"]', adminEmail);
  await page.fill('input[name="password"]', adminPassword);
  await submitAndWait(page, () => page.locator('button[type="submit"]').click());
  await page.waitForURL(/\/admin$/, { timeout: 10000 });
  await expectText(page, 'Tổng quan');
  await expectText(page, 'Đăng xuất');
  assert(await page.getByText('Xem website', { exact: false }).count() === 0, 'Header vẫn còn nút Xem website');

  console.log('2. Kiểm tra điều hướng sidebar');
  const navItems = [
    ['Phim', /\/admin\/movies/],
    ['Phòng chiếu', /\/admin\/rooms/],
    ['Suất chiếu', /\/admin\/showtimes/],
    ['Đặt vé', /\/admin\/bookings/],
    ['Người dùng', /\/admin\/users/],
  ];
  for (const [label, urlPattern] of navItems) {
    await page.getByRole('link', { name: label }).click();
    await page.waitForURL(urlPattern, { timeout: 10000 });
    await expectText(page, label.split(' ')[0]);
  }

  console.log('3. Kiểm tra người dùng có dữ liệu và cập nhật user');
  await page.goto(`${baseURL}/admin/users`, { waitUntil: 'networkidle' });
  await expectText(page, 'Người dùng');
  assert(await firstCount(page.locator('table tbody tr')) > 0, 'Trang Người dùng không có dữ liệu');
  await page.fill('input[name="q"]', 'minhanh@example.com');
  await submitAndWait(page, () => page.getByRole('button', { name: 'Tìm' }).click());
  await expectText(page, 'minhanh@example.com');
  await page.locator('input[name="name"]').first().fill('Nguyễn Minh Anh');
  await submitAndWait(page, () => page.locator('button[type="submit"]', { hasText: 'Lưu' }).first().click());
  await expectText(page, 'Đã cập nhật người dùng');

  console.log('4. Kiểm tra CRUD phim tạm');
  const movieTitle = `Phim kiểm thử ${Date.now()}`;
  await page.goto(`${baseURL}/admin/movies`, { waitUntil: 'networkidle' });
  await page.getByRole('link', { name: 'Thêm phim' }).click();
  await page.waitForURL(/\/admin\/movies\/create/);
  await page.fill('input[name="title"]', movieTitle);
  await page.fill('textarea[name="description"]', 'Mô tả kiểm thử giao diện quản trị.');
  await page.fill('input[name="genre"]', 'Hành động');
  await page.fill('input[name="duration"]', '110');
  await page.fill('input[name="language"]', 'Tiếng Việt');
  await page.fill('input[name="release_date"]', '2026-05-20');
  await page.fill('input[name="age_label"]', 'C13');
  await submitAndWait(page, () => page.getByRole('button', { name: 'Lưu phim' }).click());
  await page.waitForURL(/\/admin\/movies/);
  await expectText(page, 'Đã thêm phim');
  await page.fill('input[name="q"]', movieTitle);
  await submitAndWait(page, () => page.getByRole('button', { name: 'Tìm' }).click());
  await expectText(page, movieTitle);
  await page.getByRole('link', { name: 'Sửa' }).first().click();
  await page.fill('input[name="duration"]', '111');
  await submitAndWait(page, () => page.getByRole('button', { name: 'Lưu phim' }).click());
  await expectText(page, 'Đã cập nhật phim');
  await page.fill('input[name="q"]', movieTitle);
  await submitAndWait(page, () => page.getByRole('button', { name: 'Tìm' }).click());
  page.once('dialog', dialog => dialog.accept());
  await submitAndWait(page, () => page.getByRole('button', { name: 'Xóa' }).first().click());
  await expectText(page, 'Đã xóa phim');

  console.log('5. Kiểm tra phòng, ghế');
  const roomName = `Phòng test ${Date.now()}`;
  await page.goto(`${baseURL}/admin/rooms`, { waitUntil: 'networkidle' });
  await expectText(page, 'Them phong');
  assert(await firstCount(page.locator('.admin-panel')) > 1, 'Trang phòng chưa có dữ liệu');
  await page.locator('input[name="name"][placeholder="Tên phòng"]').first().fill(roomName);
  await page.locator('input[name="total_seats"][placeholder="Số ghế"]').first().fill('6');
  await submitAndWait(page, () => page.getByRole('button', { name: 'Thêm phòng' }).first().click());
  await expectText(page, 'Đã thêm phòng chiếu');
  await page.getByRole('link', { name: 'Ghế' }).first().click();
  await page.waitForURL(/\/admin\/rooms\/.*\/seats/);
  await expectText(page, 'Loại ghế');
  await page.locator('select[name="seat_type"]').first().selectOption('vip');
  await submitAndWait(page, () => page.getByRole('button', { name: 'Lưu' }).first().click());
  await expectText(page, 'Đã cập nhật ghế');
  await page.goto(`${baseURL}/admin/rooms`, { waitUntil: 'networkidle' });
  page.once('dialog', dialog => dialog.accept());
  await submitAndWait(page, () => page.locator(`xpath=//tr[.//input[@name="name" and @value="${roomName}"]]//button[normalize-space()="Xóa"]`).click());
  await expectText(page, 'Đã xóa phòng chiếu');

  console.log('6. Kiểm tra suất chiếu');
  await page.goto(`${baseURL}/admin/showtimes`, { waitUntil: 'networkidle' });
  await expectText(page, 'Thêm suất chiếu');
  assert(await page.locator('select[name="movie_id"] option').count() > 1, 'Không có phim để tạo suất chiếu');
  assert(await page.locator('select[name="room_id"] option').count() > 1, 'Không có phòng để tạo suất chiếu');
  await page.locator('select[name="movie_id"]').first().selectOption({ index: 1 });
  await page.locator('select[name="room_id"]').first().selectOption({ index: 1 });
  const testDay = String((Date.now() % 20) + 1).padStart(2, '0');
  const testHour = String((Date.now() % 8) + 9).padStart(2, '0');
  await page.fill('input[name="start_time"]', `2026-07-${testDay}T${testHour}:00`);
  await page.fill('input[name="end_time"]', `2026-07-${testDay}T${String(Number(testHour) + 2).padStart(2, '0')}:00`);
  await page.fill('input[name="price"]', '85000');
  await page.fill('input[name="format"]', '2D Phụ đề');
  await submitAndWait(page, () => page.getByRole('button', { name: 'Thêm suất chiếu' }).click());
  await expectText(page, 'Đã thêm suất chiếu');
  assert(await firstCount(page.locator('table tbody tr')) > 0, 'Danh sách suất chiếu trống');
  page.once('dialog', dialog => dialog.accept());
  await submitAndWait(page, () => page.getByRole('button', { name: 'Xóa' }).first().click());
  await expectText(page, 'Đã xóa suất chiếu');

  console.log('7. Kiểm tra đặt vé, lọc, chi tiết, cập nhật trạng thái');
  await page.goto(`${baseURL}/admin/bookings`, { waitUntil: 'networkidle' });
  await expectText(page, 'Danh sách đặt vé');
  assert(await firstCount(page.locator('table tbody tr')) > 0, 'Trang Đặt vé không có dữ liệu');
  await page.locator('select[name="status"]').selectOption('paid');
  await submitAndWait(page, () => page.getByRole('button', { name: 'Lọc' }).click());
  assert(await firstCount(page.locator('table tbody tr')) > 0, 'Lọc booking đã thanh toán không có dữ liệu');
  await page.getByRole('link', { name: 'Chi tiết' }).first().click();
  await page.waitForURL(/\/admin\/bookings\/.+/);
  await expectText(page, 'Thanh toán');
  await page.locator('select[name="booking_status"]').selectOption('checked_in');
  await submitAndWait(page, () => page.getByRole('button', { name: 'Cập nhật trạng thái' }).click());
  await expectText(page, 'Đã cập nhật đặt vé');

  console.log('8. Kiểm tra cấu hình admin');
  await page.goto(`${baseURL}/admin/settings`, { waitUntil: 'networkidle' });
  await expectText(page, 'Cấu hình vận hành');
  await page.fill('input[name="site_name"]', 'Beta Cinemas');
  await page.fill('input[name="support_phone"]', '1900 636807');
  await page.fill('input[name="default_ticket_price"]', '75000');
  await page.fill('input[name="booking_hold_minutes"]', '10');
  await submitAndWait(page, () => page.getByRole('button', { name: 'Lưu cấu hình' }).click());
  await expectText(page, 'Đã lưu cấu hình');

  console.log('9. Kiểm tra đăng xuất ở sidebar');
  await page.getByRole('button', { name: 'Đăng xuất' }).click();
  await page.waitForURL(/\/admin\/login/, { timeout: 10000 });
  await expectText(page, 'Đăng nhập quản trị');

  assert(errors.length === 0, `Có lỗi console/page: ${errors.join('\n')}`);
  console.log('ADMIN_FLOW_OK');
} finally {
  await context.close();
  await browser.close();
}

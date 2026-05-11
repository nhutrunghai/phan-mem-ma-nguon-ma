<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Movie;
use App\Models\PasswordResetOtp;
use App\Models\Room;
use App\Models\Seat;
use App\Models\Showtime;
use App\Models\User;
use App\Services\MovieCatalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

function betaDemoUserSessionPayload(User $user): array
{
    return [
        'id' => (string) $user->getKey(),
        'name' => $user->name ?: 'Beta Member',
        'email' => $user->email,
        'phone' => $user->phone ?? '',
        'role' => $user->role ?? 'user',
        'status' => (bool) ($user->status ?? true),
        'birthday' => $user->birthday ?? '',
        'gender' => $user->gender ?? '',
        'identity_number' => $user->identity_number ?? '',
        'province' => $user->province ?? '',
        'district' => $user->district ?? '',
        'address' => $user->address ?? '',
        'favorite_cinema' => $user->favorite_cinema ?? '',
    ];
}

function betaRefreshActiveDemoUserSession(): bool
{
    $demoUser = session('demo_user', []);
    $userId = is_array($demoUser) ? ($demoUser['id'] ?? null) : null;

    if ($userId === null) {
        return session()->has('demo_user');
    }

    $user = User::query()->find((string) $userId);

    if (! $user || ($user->status ?? true) === false) {
        session()->forget('demo_user');

        return false;
    }

    session(['demo_user' => array_merge($demoUser, betaDemoUserSessionPayload($user))]);

    return true;
}

function betaSiteData(): array
{
    $dataPath = resource_path('data/web-home.json');
    $siteData = [];

    if (is_readable($dataPath)) {
        $decoded = json_decode(file_get_contents($dataPath), true);

        if (is_array($decoded)) {
            $siteData = $decoded;
        }
    }

    return $siteData;
}

function betaTopLinks(array $siteData): array
{
    return collect($siteData['topLinks'] ?? [])->values()->map(function (array $item, int $index) {
        if ($index === 0) {
            $item['href'] = route('auth.login.form');
        } elseif ($index === 1) {
            $item['href'] = route('auth.register.form');
        } elseif (str_ends_with((string) ($item['href'] ?? ''), '.php')) {
            $item['href'] = '#';
        }

        return $item;
    })->all();
}

function betaNavItems(array $siteData): array
{
    return collect($siteData['nav'] ?? [])->map(function (array $item) {
        $label = (string) ($item['label'] ?? '');

        if (in_array(betaRepairMojibakeString($label), ['L?CH CHI?U THEO R?P'], true)) {
            $item['href'] = route('schedule.index');
        } elseif ($label === 'PHIM') {
            $item['href'] = route('movies.index');
        } elseif (in_array(betaRepairMojibakeString($label), ['THÀNH VIÊN'], true)) {
            $item['href'] = route('account.show');
        } else {
            $item['href'] = '#';
        }

        return $item;
    })->all();
}

function betaRepairMojibakeString(string $value): string
{
    if (!preg_match('/(?:\x{00C3}|\x{00C2}|\x{00C6}|\x{00C4}|\x{00E1}\x{00BA}|\x{00E1}\x{00BB}|\x{00E2}\x{20AC})/u', $value)) {
        return $value;
    }

    $bytes = @mb_convert_encoding($value, 'Windows-1252', 'UTF-8');

    if (!is_string($bytes) || !mb_check_encoding($bytes, 'UTF-8')) {
        return $value;
    }

    return $bytes;
}

function betaRepairMovieText(array $value): array
{
    array_walk_recursive($value, function (&$item): void {
        if (is_string($item)) {
            $item = betaRepairMojibakeString($item);
        }
    });

    return $value;
}

function betaFilterMovies(array $movies, string $tab = '', string $search = '', string $genre = ''): array
{
    $search = trim(mb_strtolower($search));
    $genre = trim(mb_strtolower($genre));

    return collect($movies)->filter(function (array $movie) use ($tab, $search, $genre) {
        $movieTitle = mb_strtolower((string) ($movie['title'] ?? ''));
        $movieGenre = mb_strtolower((string) ($movie['genre'] ?? ''));
        $movieSection = (string) ($movie['section'] ?? '');

        if ($tab !== '' && $movieSection !== $tab) {
            return false;
        }

        if ($search !== '' && !str_contains($movieTitle, $search)) {
            return false;
        }

        if ($genre !== '' && !str_contains($movieGenre, $genre)) {
            return false;
        }

        return true;
    })->values()->all();
}

function betaResolvedNavItems(array $siteData): array
{
    return collect($siteData['nav'] ?? [])->values()->map(function (array $item, int $index) {
        return match ($index) {
            0 => array_merge($item, ['href' => route('schedule.index')]),
            1 => array_merge($item, ['href' => route('movies.index')]),
            2 => array_merge($item, ['href' => route('cinemas.info')]),
            3 => array_merge($item, ['href' => route('prices.index')]),
            4 => array_merge($item, ['href' => route('promotions.index')]),
            5 => array_merge($item, ['href' => route('franchise.index')]),
            6 => array_merge($item, ['href' => route('member.index')]),
            default => array_merge($item, ['href' => '#']),
        };
    })->all();
}

Route::get('/', function () {
    $siteData = betaSiteData();

    return view('home', [
        'title' => 'Beta Cinemas',
        'topLinks' => betaTopLinks($siteData),
        'navItems' => betaResolvedNavItems($siteData),
        'slides' => $siteData['hero'] ?? [],
        'movieTabs' => $siteData['movieTabs'] ?? [],
        'movies' => app(MovieCatalog::class)->activeMovies(),
        'footer' => $siteData['footer'] ?? [],
    ]);
});

Route::get('/lich-chieu', function () {
    $siteData = betaSiteData();
    $movies = app(MovieCatalog::class)->activeMovies();
    $topScheduleDates = [];
    $search = trim((string) request()->query('q', ''));
    $genre = trim((string) request()->query('genre', ''));
    $requestedDate = trim((string) request()->query('date', ''));
    $movies = betaFilterMovies($movies, '', $search, $genre);

    foreach ($movies as $movie) {
        if (!empty($movie['scheduleDates'])) {
            $topScheduleDates = $movie['scheduleDates'];
            break;
        }
    }

    $availableDateKeys = collect($topScheduleDates)
        ->map(fn(array $date): string => trim(($date['label'] ?? '') . ($date['suffix'] ?? '')))
        ->filter()
        ->values()
        ->all();
    $activeScheduleDate = in_array($requestedDate, $availableDateKeys, true)
        ? $requestedDate
        : ($availableDateKeys[0] ?? '');

    $topScheduleDates = collect($topScheduleDates)->map(function (array $date) use ($activeScheduleDate) {
        $key = trim(($date['label'] ?? '') . ($date['suffix'] ?? ''));
        $date['active'] = $key === $activeScheduleDate;

        return $date;
    })->all();

    $scheduleMovies = [];
    foreach ($movies as $movie) {
        $scheduleDates = $movie['scheduleDates'] ?? [];
        $scheduleByDate = $movie['scheduleByDate'] ?? [];
        $selectedDate = $activeScheduleDate;

        if ($selectedDate === '') {
            foreach ($scheduleDates as $date) {
                if (!empty($date['active'])) {
                    $selectedDate = trim(($date['label'] ?? '') . ($date['suffix'] ?? ''));
                    break;
                }
            }
        }

        if ($selectedDate === '' && !empty($scheduleDates)) {
            $selectedDate = trim(($scheduleDates[0]['label'] ?? '') . ($scheduleDates[0]['suffix'] ?? ''));
        }

        $activeGroups = $movie['showtimeGroups'] ?? [];
        foreach ($scheduleByDate as $date) {
            $key = trim(($date['label'] ?? '') . ($date['suffix'] ?? ''));
            if ($key === $selectedDate) {
                $activeGroups = $date['groups'] ?? $activeGroups;
                break;
            }
        }

        if ($activeGroups === []) {
            continue;
        }

        $scheduleMovies[] = [
            'movie' => $movie,
            'activeGroups' => $activeGroups,
            'selectedDate' => $selectedDate,
        ];
    }

    return view('schedule', [
        'title' => 'L?ch chi?u - Beta Cinemas',
        'topLinks' => betaTopLinks($siteData),
        'navItems' => betaResolvedNavItems($siteData),
        'footer' => $siteData['footer'] ?? [],
        'topScheduleDates' => $topScheduleDates,
        'scheduleMovies' => $scheduleMovies,
        'search' => $search,
        'genre' => $genre,
        'activeScheduleDate' => $activeScheduleDate,
    ]);
})->name('schedule.index');

Route::get('/phim', function (Request $request) {
    $siteData = betaSiteData();
    $movieTabs = $siteData['movieTabs'] ?? [];
    $movies = app(MovieCatalog::class)->activeMovies();
    $defaultTab = collect($movieTabs)->firstWhere('active', true)['id'] ?? 'now-showing';
    $activeTab = (string) $request->query('tab', $defaultTab);
    $search = (string) $request->query('q', '');
    $genre = (string) $request->query('genre', '');

    if (!in_array($activeTab, array_column($movieTabs, 'id'), true)) {
        $activeTab = $movieTabs[0]['id'] ?? 'upcoming';
    }

    $movies = betaFilterMovies($movies, $activeTab, $search, $genre);

    return view('movies', [
        'title' => 'Phim - Beta Cinemas',
        'topLinks' => betaTopLinks($siteData),
        'navItems' => betaResolvedNavItems($siteData),
        'footer' => $siteData['footer'] ?? [],
        'movieTabs' => $movieTabs,
        'movies' => $movies,
        'activeTab' => $activeTab,
        'search' => $search,
        'genre' => $genre,
    ]);
})->name('movies.index');

Route::get('/phim/{id}', function (string $id) {
    $siteData = betaSiteData();
    $movie = app(MovieCatalog::class)->findMovieBySlug($id);

    abort_if($movie === null, 404);


    return view('movie-detail', [
        'title' => ($movie['title'] ?? 'Chi tiet phim') . ' - Beta Cinemas',
        'movie' => $movie,
        'topLinks' => betaTopLinks($siteData),
        'navItems' => betaResolvedNavItems($siteData),
        'footer' => $siteData['footer'] ?? [],
    ]);
})->name('movies.show');

Route::get('/dat-ve/{id}', [BookingController::class, 'show'])->name('booking.seats');
Route::post('/dat-ve/{id}', [BookingController::class, 'store'])->name('booking.store');
Route::get('/thanh-toan/return/vnpay', [BookingController::class, 'paymentReturn'])->name('payment.return.vnpay');
Route::post('/thanh-toan/ipn/vnpay', [BookingController::class, 'paymentIpn'])->name('payment.ipn.vnpay');
Route::post('/thanh-toan/ipn/sepay', [BookingController::class, 'sePayWebhook'])->name('payment.ipn.sepay');
Route::post('/api/v1/check-payment', [BookingController::class, 'sePayWebhook'])->name('payment.sepay.webhook');
Route::get('/thanh-toan/{booking}', [BookingController::class, 'paymentPage'])->name('bookings.payment');
Route::post('/thanh-toan/{booking}', [BookingController::class, 'confirmPayment'])->name('bookings.payment.confirm');

Route::get('/thong-tin-rap', function () {
    return view('cinemas-info');
})->name('cinemas.info');

Route::get('/gia-ve', function () {
    return view('prices');
})->name('prices.index');

Route::get('/tin-moi-va-uu-dai', function () {
    return view('promotions');
})->name('promotions.index');

Route::get('/nhuong-quyen', function () {
    return view('franchise');
})->name('franchise.index');

Route::get('/thanh-vien', function () {
    if (betaRefreshActiveDemoUserSession()) {
        return redirect()->route('account.show');
    }

    return redirect()->to(route('auth.login.form') . '#login');
})->name('member.index');

Route::get('/demo-auth/login', function (Request $request) {
    $email = trim((string) $request->query('email', ''));
    $password = (string) $request->query('password', '');
    $user = $email !== '' ? User::query()->where('email', $email)->first() : null;

    if (! $user || ! Hash::check($password, (string) $user->password)) {
        return redirect()
            ->to(route('auth.login.form') . '#login')
            ->withErrors(['email' => 'Email ho?c m?t kh?u không dúng.'])
            ->withInput(['email' => $email]);
    }

    if (($user->status ?? true) === false) {
        session()->forget(['demo_user', 'admin_authenticated', 'admin_email', 'admin_user_id']);

        return redirect()
            ->to(route('auth.login.form') . '#login')
            ->withErrors(['email' => 'Tài kho?n dã b? khóa.'])
            ->withInput(['email' => $email]);
    }

    session(['demo_user' => betaDemoUserSessionPayload($user)]);

    return redirect()->route('account.show');
})->name('auth.login.submit');

Route::get('/dang-nhap', function () {
    $siteData = betaSiteData();

    return view('auth', [
        'title' => 'Ðang nh?p - Beta Cinemas',
        'mode' => 'login',
        'topLinks' => betaTopLinks($siteData),
        'navItems' => betaResolvedNavItems($siteData),
        'footer' => $siteData['footer'] ?? [],
    ]);
})->name('auth.login.form');

Route::post('/quen-mat-khau/gui-ma', function (Request $request) {
    $data = $request->validate([
        'email' => ['required', 'email', 'max:160'],
    ]);

    $email = mb_strtolower(trim($data['email']));
    $user = User::query()->where('email', $email)->first();

    if (! $user) {
        return back()
            ->withErrors(['email' => 'Email này chua du?c dang ký.'])
            ->withInput(['email' => $email]);
    }

    if (($user->status ?? true) === false) {
        return back()
            ->withErrors(['email' => 'Tài kho?n dã b? khóa, không th? d?t l?i m?t kh?u.'])
            ->withInput(['email' => $email]);
    }

    $code = (string) random_int(100000, 999999);

    PasswordResetOtp::query()
        ->where('email', $email)
        ->whereNull('used_at')
        ->delete();

    PasswordResetOtp::query()->create([
        'email' => $email,
        'code_hash' => Hash::make($code),
        'attempts' => 0,
        'expires_at' => now()->addMinutes(10),
        'used_at' => null,
    ]);

    try {
        Mail::raw(
            "Mã OTP d?t l?i m?t kh?u Beta Cinemas c?a b?n là: {$code}\n\nMã này h?t h?n sau 10 phút.",
            function ($message) use ($email): void {
                $message->to($email)->subject('Mã OTP d?t l?i m?t kh?u Beta Cinemas');
            }
        );
    } catch (Throwable) {
        PasswordResetOtp::query()
            ->where('email', $email)
            ->whereNull('used_at')
            ->delete();

        return back()
            ->withErrors(['email' => 'Không g?i du?c email OTP. Vui lòng th? l?i sau.'])
            ->withInput(['email' => $email]);
    }

    return redirect()
        ->route('password.reset.form', ['email' => $email])
        ->with('status', 'Mã OTP dã du?c g?i v? email c?a b?n.');
})->name('password.otp.send');

Route::get('/dat-lai-mat-khau', function (Request $request) {
    return view('password-reset', [
        'title' => 'Ð?t l?i m?t kh?u | Beta Cinemas',
        'email' => trim((string) $request->query('email', '')),
    ]);
})->name('password.reset.form');

Route::post('/dat-lai-mat-khau', function (Request $request) {
    $data = $request->validate([
        'email' => ['required', 'email', 'max:160'],
        'otp' => ['required', 'digits:6'],
        'password' => ['required', 'string', 'min:6', 'confirmed'],
    ]);

    $email = mb_strtolower(trim($data['email']));
    $otp = PasswordResetOtp::query()
        ->where('email', $email)
        ->whereNull('used_at')
        ->where('expires_at', '>', now())
        ->orderByDesc('created_at')
        ->first();

    if (! $otp) {
        return back()
            ->withErrors(['otp' => 'Mã OTP không t?n t?i ho?c dã h?t h?n.'])
            ->withInput(['email' => $email]);
    }

    if (($otp->attempts ?? 0) >= 5) {
        $otp->forceFill(['used_at' => now()])->save();

        return back()
            ->withErrors(['otp' => 'Mã OTP dã b? khóa do nh?p sai quá nhi?u l?n. Vui lòng g?i mã m?i.'])
            ->withInput(['email' => $email]);
    }

    if (! Hash::check($data['otp'], (string) $otp->code_hash)) {
        $otp->increment('attempts');

        return back()
            ->withErrors(['otp' => 'Mã OTP không dúng.'])
            ->withInput(['email' => $email]);
    }

    $user = User::query()->where('email', $email)->first();

    if (! $user || ($user->status ?? true) === false) {
        return back()
            ->withErrors(['email' => 'Tài kho?n không t?n t?i ho?c dã b? khóa.'])
            ->withInput(['email' => $email]);
    }

    $user->forceFill([
        'password' => Hash::make($data['password']),
    ])->save();

    $otp->forceFill(['used_at' => now()])->save();
    PasswordResetOtp::query()
        ->where('email', $email)
        ->whereNull('used_at')
        ->delete();

    session()->forget('demo_user');

    return redirect()
        ->to(route('auth.login.form') . '#login')
        ->with('status', 'Ðã d?i m?t kh?u. Vui lòng dang nh?p l?i.');
})->name('password.reset.update');

Route::get('/demo-auth/register', function (Request $request) {
    $name = trim((string) $request->query('name', 'Beta Member'));
    $email = trim((string) $request->query('email', 'member@betacinemas.vn'));
    $password = (string) $request->query('password', '');
    $birthday = trim((string) $request->query('birthday', ''));
    $phone = trim((string) $request->query('phone', ''));
    $gender = trim((string) $request->query('gender', ''));
    $gender = [
        '1' => 'male',
        '2' => 'female',
        '3' => 'other',
        'male' => 'male',
        'female' => 'female',
        'other' => 'other',
    ][$gender] ?? '';

    $data = validator([
        'name' => $name,
        'email' => $email,
        'password' => $password,
        'birthday' => $birthday,
        'phone' => $phone,
        'gender' => $gender,
    ], [
        'name' => ['required', 'string', 'max:120'],
        'email' => ['required', 'email', 'max:160', 'unique:users,email'],
        'password' => ['required', 'string', 'min:6'],
        'birthday' => ['nullable', 'string', 'max:40'],
        'phone' => ['nullable', 'string', 'max:40'],
        'gender' => ['nullable', 'string', 'in:male,female,other'],
    ])->validate();

    $user = User::query()->create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => $data['password'],
        'phone' => $data['phone'] ?? null,
        'role' => 'user',
        'status' => true,
    ]);

    session(['demo_user' => array_merge(betaDemoUserSessionPayload($user), [
        'birthday' => $data['birthday'] ?? '',
        'gender' => $data['gender'] ?? '',
    ])]);

    return redirect()->route('account.show');
})->name('auth.register.submit');

Route::get('/dang-ky', function () {
    $siteData = betaSiteData();

    return view('auth', [
        'title' => 'Ðang ký - Beta Cinemas',
        'mode' => 'register',
        'topLinks' => betaTopLinks($siteData),
        'navItems' => betaResolvedNavItems($siteData),
        'footer' => $siteData['footer'] ?? [],
    ]);
})->name('auth.register.form');

Route::get('/dang-xuat', function () {
    session()->forget('demo_user');

    return redirect('/');
})->name('auth.logout');

Route::get('/tai-khoan', function (Request $request) {
    if (! betaRefreshActiveDemoUserSession()) {
        return redirect()->to(route('auth.login.form') . '#login');
    }

    $activeTab = $request->query('tab', 'profile');
    $allowedTabs = ['profile', 'history', 'points', 'password'];

    if (!in_array($activeTab, $allowedTabs, true)) {
        $activeTab = 'profile';
    }

    $demoUser = session('demo_user', []);
    $demoEmail = is_array($demoUser) ? (string) ($demoUser['email'] ?? '') : '';
    $bookings = collect();

    if ($demoEmail !== '') {
        Booking::query()
            ->where('booking_status', 'booked')
            ->whereIn('payment_status', ['pending', 'pending_gateway'])
            ->whereNotNull('hold_expires_at')
            ->where('hold_expires_at', '<=', now())
            ->update(['booking_status' => 'expired']);

        $bookings = Booking::query()
            ->with(['showtime.movie', 'showtime.room', 'seats.seat'])
            ->where('customer_email', $demoEmail)
            ->orderByDesc('created_at')
            ->get()
            ->map(function (Booking $booking) {
                $showtime = $booking->showtime;
                $movie = $showtime?->movie;
                $room = $showtime?->room;
                return [
                    'booking_id' => (string) $booking->getKey(),
                    'code' => $booking->qr_code,
                    'movie_title' => $movie?->title ?? 'Beta Cinemas',
                    'room' => $room?->name ?? '',
                    'show_date' => $showtime?->start_time?->format('d/m/Y') ?? '',
                    'show_time' => $showtime?->start_time?->format('H:i') ?? '',
                    'seats' => $booking->seats
                        ->map(fn(BookingSeat $bookingSeat) => $bookingSeat->seat?->seat_number)
                        ->filter()
                        ->values()
                        ->all(),
                    'total' => (int) $booking->total_price,
                    'status' => $booking->booking_status === 'expired'
                        ? 'H?t h?n'
                        : ($booking->payment_status === 'paid' ? 'Ðã thanh toán' : 'Ch? thanh toán'),
                    'is_expired' => $booking->booking_status === 'expired',
                    'is_pending_payment' => $booking->booking_status !== 'expired' && $booking->payment_status !== 'paid',
                    'payment_url' => $booking->booking_status !== 'expired'
                        ? route('bookings.payment', ['booking' => (string) $booking->getKey()], false)
                        : null,
                    'created_at' => $booking->created_at?->format('d/m/Y H:i') ?? '',
                ];
            });
    }

    return view('account', [
        'title' => 'Tài kho?n | Beta Cinemas',
        'activeTab' => $activeTab,
        'bookings' => $bookings->values()->all(),
    ]);
})->name('account.show');

Route::post('/tai-khoan', function (Request $request) {
    if (! betaRefreshActiveDemoUserSession()) {
        return redirect()->to(route('auth.login.form') . '#login');
    }

    $validated = $request->validate([
        'name' => ['required', 'string', 'max:120'],
        'email' => ['required', 'email', 'max:160'],
        'phone' => ['nullable', 'string', 'max:40'],
        'birthday' => ['nullable', 'string', 'max:40'],
        'gender' => ['nullable', 'string', 'in:male,female,other'],
        'identity_number' => ['nullable', 'string', 'max:40'],
        'province' => ['nullable', 'string', 'max:120'],
        'district' => ['nullable', 'string', 'max:120'],
        'address' => ['nullable', 'string', 'max:255'],
        'favorite_cinema' => ['nullable', 'string', 'max:160'],
    ]);

    $demoUser = session('demo_user', []);
    $demoUser = is_array($demoUser) ? $demoUser : [];

    $updatedProfile = array_merge($demoUser, [
        'name' => trim($validated['name']),
        'email' => trim($validated['email']),
        'phone' => trim((string) ($validated['phone'] ?? '')),
        'birthday' => trim((string) ($validated['birthday'] ?? '')),
        'gender' => trim((string) ($validated['gender'] ?? '')),
        'identity_number' => trim((string) ($validated['identity_number'] ?? '')),
        'province' => trim((string) ($validated['province'] ?? '')),
        'district' => trim((string) ($validated['district'] ?? '')),
        'address' => trim((string) ($validated['address'] ?? '')),
        'favorite_cinema' => trim((string) ($validated['favorite_cinema'] ?? '')),
    ]);

    if (empty($updatedProfile['member_code'])) {
        $updatedProfile['member_code'] = 'BC' . now()->format('ymdHis');
    }

    $userId = $demoUser['id'] ?? null;

    if ($userId !== null) {
        $duplicateEmail = User::query()
            ->where('email', $updatedProfile['email'])
            ->where('_id', '!=', (string) $userId)
            ->exists();

        if ($duplicateEmail) {
            return back()
                ->withErrors(['email' => 'Email này dã du?c s? d?ng b?i tài kho?n khác.'])
                ->withInput();
        }

        $user = User::query()->find((string) $userId);

        if (! $user || ($user->status ?? true) === false) {
            session()->forget('demo_user');

            return redirect()->to(route('auth.login.form') . '#login');
        }

        $user->forceFill([
            'name' => $updatedProfile['name'],
            'email' => $updatedProfile['email'],
            'phone' => $updatedProfile['phone'],
            'birthday' => $updatedProfile['birthday'],
            'gender' => $updatedProfile['gender'],
            'identity_number' => $updatedProfile['identity_number'],
            'province' => $updatedProfile['province'],
            'district' => $updatedProfile['district'],
            'address' => $updatedProfile['address'],
            'favorite_cinema' => $updatedProfile['favorite_cinema'],
        ])->save();
    }

    session(['demo_user' => $updatedProfile]);

    return redirect()
        ->route('account.show', ['tab' => 'profile'])
        ->with('status', 'Da cap nhat thong tin tai khoan.');
})->name('account.update');

Route::get('/admin/login', function () {
    if (session('admin_authenticated') === true) {
        return redirect()->route('admin.dashboard');
    }

    return view('admin.login');
})->name('admin.login');

Route::post('/admin/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    $adminEmail = env('ADMIN_EMAIL', 'admin@example.com');
    $adminPassword = env('ADMIN_PASSWORD', 'password');

    if ($credentials['email'] === $adminEmail && $credentials['password'] === $adminPassword) {
        session([
            'admin_authenticated' => true,
            'admin_email' => $credentials['email'],
            'admin_user_id' => null,
        ]);

        return redirect()->route('admin.dashboard');
    }

    $admin = User::query()->where('email', $credentials['email'])->first();

    if (! $admin || ! Hash::check($credentials['password'], (string) $admin->password)) {
        return back()
            ->withErrors(['email' => 'Thông tin dang nh?p qu?n tr? không dúng.'])
            ->withInput();
    }

    if (($admin->status ?? true) === false) {
        return back()
            ->withErrors(['email' => 'Tài kho?n qu?n tr? dã b? khóa.'])
            ->withInput();
    }

    if (($admin->role ?? 'user') !== 'admin') {
        return back()
            ->withErrors(['email' => 'Tài kho?n chua có quy?n qu?n tr?.'])
            ->withInput();
    }

    session([
        'admin_authenticated' => true,
        'admin_email' => $admin->email,
        'admin_user_id' => (string) $admin->getKey(),
    ]);

    return redirect()->route('admin.dashboard');
})->name('admin.login.submit');

Route::post('/admin/logout', function () {
    session()->forget(['admin_authenticated', 'admin_email', 'admin_user_id']);

    return redirect()->route('admin.login')->with('status', 'Ðã dang xu?t qu?n tr?.');
})->name('admin.logout');

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/movies', [AdminController::class, 'movies'])->name('movies.index');
    Route::get('/movies/create', [AdminController::class, 'createMovie'])->name('movies.create');
    Route::post('/movies', [AdminController::class, 'storeMovie'])->name('movies.store');
    Route::get('/movies/{movie}/edit', [AdminController::class, 'editMovie'])->name('movies.edit');
    Route::put('/movies/{movie}', [AdminController::class, 'updateMovie'])->name('movies.update');
    Route::delete('/movies/{movie}', [AdminController::class, 'deleteMovie'])->name('movies.delete');

    Route::get('/rooms', [AdminController::class, 'rooms'])->name('rooms.index');
    Route::get('/cinemas', fn () => redirect()->route('admin.settings.index'))->name('cinemas.index');
    Route::post('/rooms', [AdminController::class, 'storeRoom'])->name('rooms.store');
    Route::put('/rooms/{room}', [AdminController::class, 'updateRoom'])->name('rooms.update');
    Route::delete('/rooms/{room}', [AdminController::class, 'deleteRoom'])->name('rooms.delete');
    Route::get('/rooms/{room}/seats', [AdminController::class, 'seats'])->name('rooms.seats');
    Route::put('/seats/{seat}', [AdminController::class, 'updateSeat'])->name('seats.update');

    Route::get('/showtimes', [AdminController::class, 'showtimes'])->name('showtimes.index');
    Route::post('/showtimes', [AdminController::class, 'storeShowtime'])->name('showtimes.store');
    Route::put('/showtimes/{showtime}', [AdminController::class, 'updateShowtime'])->name('showtimes.update');
    Route::delete('/showtimes/{showtime}', [AdminController::class, 'deleteShowtime'])->name('showtimes.delete');

    Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminController::class, 'bookingDetail'])->name('bookings.show');
    Route::put('/bookings/{booking}', [AdminController::class, 'updateBooking'])->name('bookings.update');

    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');

    Route::get('/settings', [AdminController::class, 'settings'])->name('settings.index');
    Route::put('/settings', [AdminController::class, 'updateSettings'])->name('settings.update');
});

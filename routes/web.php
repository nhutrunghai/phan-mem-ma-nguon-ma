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

function betaTrackerMovies(): array
{
    return [
        [
            'id' => 'phi-phong-quy-mau-rung-thieng',
            'section' => 'now-showing',
            'title' => 'Phí Phông: Quỷ Máu Rừng Thiêng',
            'genre' => 'Kinh dị, Giật gân',
            'duration' => 120,
            'label' => 'C16',
            'tag' => 'HOT',
            'poster' => 'https://files.betacorp.vn/media/images/2026/03/26/anh-chup-man-hinh-2026-03-26-114032-114119-260326-54.png',
            'buyUrl' => '',
            'description' => 'Phí Phông, loài quỷ khát máu trong truyền thuyết dân gian của đồng bào miền núi gây ám ảnh bao đời nay. Phim xoay quanh Còn (Kiều Minh Tuấn) và Dương (Minh Anh), hai pháp sư tập sự lên núi cứu người mẹ đang bị lời nguyền Phí Phông đánh gục.',
            'releaseDate' => '20/04/2026',
            'language' => 'Tiếng Việt',
            'trailer' => 'https://www.youtube.com/embed/LDvCnwE6TtA',
            'details' => [
                ['label' => 'Đạo diễn', 'value' => 'Đỗ Quốc Trung'],
                ['label' => 'Diễn viên', 'value' => 'Kiều Minh Tuấn, Nina Nutthacha Padovan, Diệp Bảo Ngọc, Đoàn Minh Anh, NSƯT Hạnh Thuý,...'],
                ['label' => 'Thể loại', 'value' => 'Kinh dị, Giật gân'],
                ['label' => 'Thời lượng', 'value' => '120 phút'],
                ['label' => 'Ngôn ngữ', 'value' => 'Tiếng Việt'],
                ['label' => 'Ngày khởi chiếu', 'value' => '20/04/2026'],
            ],
        ],
        [
            'id' => 'anh-hung',
            'section' => 'now-showing',
            'title' => 'Anh Hùng',
            'genre' => 'Tâm lý, Gia đình',
            'duration' => 122,
            'label' => 'C13',
            'tag' => 'HOT',
            'poster' => 'https://files.betacorp.vn/media/images/2026/03/31/400wx633h-113142-310326-81.jpg',
            'buyUrl' => '',
            'description' => 'Câu chuyện phim theo chân Hùng (Thái Hòa) - người cha đơn thân kiêm tài xế taxi và đồng nghiệp hãng xe là Tuấn (Võ Tấn Phát) bị cuốn vào một phi vụ lừa đảo từ thiện tiền tỉ trong khi sinh mạng cô con gái nhỏ của anh đang nằm gọn trong tay tử thần.',
            'releaseDate' => '24/04/2026',
            'language' => 'Tiếng Việt',
            'trailer' => 'https://www.youtube.com/embed/P74tpiZ8kuU',
            'details' => [
                ['label' => 'Đạo diễn', 'value' => 'Võ Thạch Thảo'],
                ['label' => 'Diễn viên', 'value' => 'Thái Hoà, Võ Tấn Phát, Đoàn Thế Vinh, Phương Thanh, Hồng Ánh, NSƯT Lê Thiện, Hoàng Minh Triết, Gia Tuệ...'],
                ['label' => 'Thể loại', 'value' => 'Tâm lý, Gia đình'],
                ['label' => 'Thời lượng', 'value' => '122 phút'],
                ['label' => 'Ngôn ngữ', 'value' => 'Tiếng Việt'],
                ['label' => 'Ngày khởi chiếu', 'value' => '24/04/2026'],
            ],
        ],
        [
            'id' => 'dai-tiec-trang-mau-8',
            'section' => 'now-showing',
            'title' => 'Đại Tiệc Trăng Máu 8',
            'genre' => 'Hài hước, Kinh dị',
            'duration' => 130,
            'label' => 'C16',
            'tag' => 'HOT',
            'poster' => 'https://files.betacorp.vn/media/images/2026/04/16/400x633-102941-160426-44.jpg',
            'buyUrl' => '',
            'description' => 'Đại Tiệc Trăng Máu 8 theo chân một vị đạo diễn hay bị coi thường trong dự án thử thách nhất đời ông: thực hiện một bộ phim dài 35 phút chỉ với một cú máy.',
            'releaseDate' => '24/04/2026',
            'language' => 'Tiếng Việt',
            'trailer' => 'https://www.youtube.com/embed/NZ9-wGErh4o',
            'details' => [
                ['label' => 'Đạo diễn', 'value' => 'Phan Gia Nhật Linh'],
                ['label' => 'Diễn viên', 'value' => 'Vân Sơn, Lê Khánh, Miu Lê, Liên Bỉnh Phát, Quốc Khánh, Quỳnh Lý, Lâm Thanh Mỹ, Quang Minh, Hứa Vĩ Văn, Hồng Ánh, NSƯT Đức Khuê, Charlie Nguyễn...'],
                ['label' => 'Thể loại', 'value' => 'Hài hước, Kinh dị'],
                ['label' => 'Thời lượng', 'value' => '130 phút'],
                ['label' => 'Ngôn ngữ', 'value' => 'Tiếng Việt'],
                ['label' => 'Ngày khởi chiếu', 'value' => '24/04/2026'],
            ],
        ],
        [
            'id' => 'heo-nam-mong',
            'section' => 'now-showing',
            'title' => 'Heo Năm Móng',
            'genre' => 'Kinh dị',
            'duration' => 103,
            'label' => 'C18',
            'tag' => '',
            'poster' => 'https://files.betacorp.vn/media/images/2026/04/08/anh-chup-man-hinh-2026-04-08-161626-161707-080426-39.png',
            'buyUrl' => '',
            'description' => 'Dựa trên truyền thuyết rùng rợn về "Cô Năm Hợi" và linh hồn bị mắc kẹt trong thân xác heo.',
            'releaseDate' => '24/04/2026',
            'language' => 'Tiếng Việt',
            'trailer' => 'https://www.youtube.com/embed/ShknvbpzZxg',
            'details' => [
                ['label' => 'Đạo diễn', 'value' => 'Võ Thanh Hòa'],
                ['label' => 'Diễn viên', 'value' => 'Võ Tấn Phát, Trần Ngọc Vàng, Nhật Ý, Thanh Thủy,..'],
                ['label' => 'Thể loại', 'value' => 'Kinh dị'],
                ['label' => 'Thời lượng', 'value' => '103 phút'],
                ['label' => 'Ngôn ngữ', 'value' => 'Tiếng Việt'],
                ['label' => 'Ngày khởi chiếu', 'value' => '24/04/2026'],
            ],
        ],
        [
            'id' => 'trum-so',
            'section' => 'now-showing',
            'title' => 'Trùm Sò',
            'genre' => 'Hài hước',
            'duration' => 105,
            'label' => 'K',
            'tag' => '',
            'poster' => 'https://files.betacorp.vn/media/images/2026/04/10/400x633-1-141724-100426-34.jpg',
            'buyUrl' => '',
            'description' => 'Ở Làng Sứa Đỏ - một ngôi làng nhỏ xa xôi heo hút, hạn hán triền miên, người dân ai cũng nghèo cũng khổ, chỉ riêng Trùm Sò là giàu nứt đố đổ vách.',
            'releaseDate' => '24/04/2026',
            'language' => 'Tiếng Việt',
            'trailer' => 'https://www.youtube.com/embed/QoKBpq_p61Q',
            'details' => [
                ['label' => 'Đạo diễn', 'value' => 'Đỗ Đức Thịnh'],
                ['label' => 'Diễn viên', 'value' => 'Đức Thịnh, Phương Nam, Mai Phương, Doãn Quốc Đam, Hoàng Tóc Dài,...'],
                ['label' => 'Thể loại', 'value' => 'Hài hước'],
                ['label' => 'Thời lượng', 'value' => '105 phút'],
                ['label' => 'Ngôn ngữ', 'value' => 'Tiếng Việt'],
                ['label' => 'Ngày khởi chiếu', 'value' => '24/04/2026'],
            ],
        ],
        [
            'id' => 'hen-em-ngay-nhat-thuc',
            'section' => 'now-showing',
            'title' => 'Hẹn Em Ngày Nhật Thực',
            'genre' => 'Tâm lý, Gia đình',
            'duration' => 118,
            'label' => 'C16',
            'tag' => '',
            'poster' => 'https://files.betacorp.vn/media/images/2026/03/18/teaser-hennt-cinema-150342-180326-62.jpg',
            'buyUrl' => '',
            'description' => 'Năm 1995, khi đang đứng trước một quyết định quan trọng của cuộc đời, Ân bất ngờ bị kéo trở lại quá khứ bởi những bức thư tình chưa từng trao tay.',
            'releaseDate' => '30/03/2026',
            'language' => 'Tiếng Việt',
            'trailer' => 'https://www.youtube.com/embed/xeuiol66BkA',
            'details' => [
                ['label' => 'Đạo diễn', 'value' => 'Lê Thiện Viễn'],
                ['label' => 'Diễn viên', 'value' => 'Đoàn Thiên Ân, Khương Lê, NSND Lê Khanh, Huỳnh Phương, Nguyên Thảo, NSND Kim Xuân, Thanh Sơn, Hứa Vĩ Văn, Lâm Vỹ Dạ, Hứa Minh Đạt.'],
                ['label' => 'Thể loại', 'value' => 'Tâm lý, Gia đình'],
                ['label' => 'Thời lượng', 'value' => '118 phút'],
                ['label' => 'Ngôn ngữ', 'value' => 'Tiếng Việt'],
                ['label' => 'Ngày khởi chiếu', 'value' => '30/03/2026'],
            ],
        ],
        [
            'id' => 'cu-nhay-ky-dieu',
            'section' => 'now-showing',
            'title' => 'Cú Nhảy Kỳ Diệu',
            'genre' => 'Hoạt hình, Phiêu lưu',
            'duration' => 105,
            'label' => 'P',
            'tag' => '',
            'poster' => 'https://files.betacorp.vn/media/images/2026/02/26/anh-chup-man-hinh-2026-02-26-151006-151102-260226-84.png',
            'buyUrl' => '',
            'description' => 'Câu chuyện xoay quanh Mabel, nữ sinh đại học 19 tuổi với tình yêu mãnh liệt dành cho động vật, đã nắm bắt cơ hội sử dụng công nghệ cho phép ý thức “nhảy” vào một chú hải ly rô-bốt.',
            'releaseDate' => '13/03/2026',
            'language' => 'Tiếng Việt',
            'trailer' => 'https://www.youtube.com/embed/CHINiUp2L0g',
            'details' => [
                ['label' => 'Đạo diễn', 'value' => 'Daniel Chong'],
                ['label' => 'Diễn viên', 'value' => ''],
                ['label' => 'Thể loại', 'value' => 'Hoạt hình, Phiêu lưu'],
                ['label' => 'Thời lượng', 'value' => '105 phút'],
                ['label' => 'Ngôn ngữ', 'value' => 'Tiếng Việt'],
                ['label' => 'Ngày khởi chiếu', 'value' => '13/03/2026'],
            ],
        ],
        [
            'id' => 'michael',
            'section' => 'now-showing',
            'title' => 'Michael',
            'genre' => 'Âm Nhạc',
            'duration' => 127,
            'label' => 'K',
            'tag' => '',
            'poster' => 'https://files.betacorp.vn/media/images/2026/04/13/anh-chup-man-hinh-2026-04-13-090338-090425-130426-13.png',
            'buyUrl' => '',
            'description' => 'Michael là tác phẩm điện ảnh khắc họa cuộc đời và di sản của một trong những nghệ sĩ có ảnh hưởng nhất mà thế giới từng biết đến.',
            'releaseDate' => '22/04/2026',
            'language' => 'Tiếng Anh',
            'trailer' => 'https://www.youtube.com/embed/I7T5VK3zqbY',
            'details' => [
                ['label' => 'Đạo diễn', 'value' => 'Antoine Fuqua'],
                ['label' => 'Diễn viên', 'value' => 'Jaafar Jackson, Nia Long, Laura Harrier, Juliano Krue Valdi, cùng Miles Teller và Colman Domingo'],
                ['label' => 'Thể loại', 'value' => 'Âm Nhạc'],
                ['label' => 'Thời lượng', 'value' => '127 phút'],
                ['label' => 'Ngôn ngữ', 'value' => 'Tiếng Anh'],
                ['label' => 'Ngày khởi chiếu', 'value' => '22/04/2026'],
            ],
        ],
        [
            'id' => 'phim-shin-cau-be-but-chi',
            'section' => 'now-showing',
            'title' => 'Phim Shin - Cậu Bé Bút Chì',
            'genre' => 'Hoạt hình, Gia đình',
            'duration' => 104,
            'label' => 'P',
            'tag' => '',
            'poster' => 'https://files.betacorp.vn/media/images/2026/04/23/poster-shin-2020-4x5-174632-230426-77.png',
            'buyUrl' => '',
            'description' => 'Bộ phim xoay quanh một vương quốc lơ lửng mang tên Rakuga, tồn tại nhờ nguồn năng lượng đến từ những nét vẽ của con người.',
            'releaseDate' => '01/05/2026',
            'language' => 'Tiếng Nhật',
            'trailer' => 'https://www.youtube.com/embed/KyyoTlt5VJo',
            'details' => [
                ['label' => 'Đạo diễn', 'value' => 'Masakazu Hashimoto'],
                ['label' => 'Diễn viên', 'value' => 'Akiko Yajima Shin Yumiko Kobayashi, Miki Narahashi,Toshiyuki Morikawa'],
                ['label' => 'Thể loại', 'value' => 'Hoạt hình, Gia đình'],
                ['label' => 'Thời lượng', 'value' => '104 phút'],
                ['label' => 'Ngôn ngữ', 'value' => 'Tiếng Nhật'],
                ['label' => 'Ngày khởi chiếu', 'value' => '01/05/2026'],
            ],
        ],
    ];
}

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

        if (in_array(betaRepairMojibakeString($label), ['LỊCH CHIẾU THEO RẠP'], true)) {
            $item['href'] = route('schedule.index');
        } elseif ($label === 'PHIM') {
            $item['href'] = route('movies.index');
        } elseif (in_array(betaRepairMojibakeString($label), ['THÀNH VIÊN'], true)) {
            $item['href'] = route('account.demo');
        } else {
            $item['href'] = '#';
        }

        return $item;
    })->all();
}

function betaMergedMovies(array $siteData): array
{
    return betaRepairMovieText(app(MovieCatalog::class)->mergedMovies($siteData, betaTrackerMovies()));
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
        'movies' => betaMergedMovies($siteData),
        'footer' => $siteData['footer'] ?? [],
    ]);
});

Route::get('/lich-chieu', function () {
    $siteData = betaSiteData();
    $movies = betaMergedMovies($siteData);
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
        'title' => 'Lịch chiếu - Beta Cinemas',
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
    $movies = betaMergedMovies($siteData);
    $activeTab = (string) $request->query('tab', 'upcoming');
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
    $movies = collect(betaMergedMovies($siteData));
    $movie = $movies->firstWhere('id', $id);

    abort_if($movie === null, 404);

    $movie['details'] = $movie['details'] ?? [
        ['label' => 'Thể loại', 'value' => $movie['genre'] ?? 'Đang cập nhật'],
        ['label' => 'Thời lượng', 'value' => (($movie['duration'] ?? null) ? ($movie['duration'] . ' phút') : 'Đang cập nhật')],
        ['label' => 'Ngôn ngữ', 'value' => $movie['language'] ?? 'Tiếng Việt'],
        ['label' => 'Ngày khởi chiếu', 'value' => $movie['releaseDate'] ?? 'Đang cập nhật'],
    ];
    $movie['scheduleDates'] = $movie['scheduleDates'] ?? [];
    $movie['showtimeGroups'] = $movie['showtimeGroups'] ?? [];
    $movie['scheduleByDate'] = $movie['scheduleByDate'] ?? [];
    $movie['showtimes'] = $movie['showtimes'] ?? [];

    return view('movie-detail', [
        'title' => ($movie['title'] ?? 'Chi tiết phim') . ' - Beta Cinemas',
        'movie' => $movie,
        'topLinks' => betaTopLinks($siteData),
        'navItems' => betaResolvedNavItems($siteData),
        'footer' => $siteData['footer'] ?? [],
    ]);
})->name('movies.show');

Route::get('/dat-ve-demo/{id}', function (Request $request, string $id) {
    $siteData = betaSiteData();
    $movies = collect(betaMergedMovies($siteData));
    $movie = $movies->firstWhere('id', $id);

    abort_if($movie === null, 404);

    $selectedDate = trim((string) $request->query('date', $movie['releaseDate'] ?? '01/05/2026'));
    $selectedTime = trim((string) $request->query('time', '19:00'));
    $selectedFormat = trim((string) $request->query('format', '2D Phụ đề'));

    $seatRows = [
        'H' => range(11, 1),
        'G' => range(11, 1),
        'F' => range(9, 1),
        'E' => range(9, 1),
        'D' => range(10, 1),
        'C' => range(10, 1),
        'B' => range(10, 1),
        'A' => range(10, 1),
    ];

    $soldSeats = ['F7', 'D5', 'C1', 'B4'];
    $heldSeats = ['E4', 'E5', 'D6'];
    $reservedSeats = ['H3', 'H4', 'G5'];
    $preselectedSeats = [];

    return view('booking.demo-seats', [
        'title' => 'Đặt vé - ' . ($movie['title'] ?? 'Beta Cinemas'),
        'movie' => $movie,
        'selectedDate' => $selectedDate,
        'selectedTime' => $selectedTime,
        'selectedFormat' => $selectedFormat,
        'seatRows' => $seatRows,
        'soldSeats' => $soldSeats,
        'heldSeats' => $heldSeats,
        'reservedSeats' => $reservedSeats,
        'preselectedSeats' => $preselectedSeats,
    ]);
})->name('booking.demo.seats');

Route::post('/dat-ve-demo/{id}', function (Request $request, string $id) {
    $siteData = betaSiteData();
    $movies = collect(betaMergedMovies($siteData));
    $movie = $movies->firstWhere('id', $id);

    abort_if($movie === null, 404);

    if (!session()->has('demo_user')) {
        return redirect()->to(route('auth.login.form') . '#login')
            ->with('status', 'Vui lòng đăng nhập trước khi tiếp tục đặt vé.');
    }

    $validated = $request->validate([
        'show_date' => ['required', 'string', 'max:80'],
        'show_time' => ['required', 'string', 'max:40'],
        'format' => ['required', 'string', 'max:80'],
        'seats' => ['required', 'string', 'max:200'],
    ]);

    $seats = collect(explode(',', $validated['seats']))
        ->map(fn(string $seat): string => trim($seat))
        ->filter()
        ->unique()
        ->values()
        ->all();

    if ($seats === []) {
        return back()->withErrors(['seats' => 'Vui lòng chọn ít nhất một ghế.'])->withInput();
    }

    $bookings = session('demo_bookings', []);
    $booking = [
        'code' => 'BC' . now()->format('His'),
        'movie_id' => $id,
        'movie_title' => $movie['title'] ?? 'Beta Cinemas',
        'show_date' => $validated['show_date'],
        'show_time' => $validated['show_time'],
        'format' => $validated['format'],
        'seats' => $seats,
        'total' => count($seats) * 50000,
        'status' => 'Chờ thanh toán',
        'created_at' => now()->format('d/m/Y H:i'),
    ];

    array_unshift($bookings, $booking);
    session(['demo_bookings' => array_slice($bookings, 0, 10)]);

    return redirect()
        ->route('booking.demo.payment', ['code' => $booking['code']])
        ->with('status', 'Đã giữ ghế ' . implode(', ', $seats) . ' cho phim ' . ($movie['title'] ?? 'Beta Cinemas') . '. Vui lòng thanh toán VNPay.');
})->name('booking.demo.store');

Route::get('/dat-ve/{id}', [BookingController::class, 'show'])->name('booking.seats');
Route::post('/dat-ve/{id}', [BookingController::class, 'store'])->name('booking.store');
Route::get('/thanh-toan/return/vnpay', [BookingController::class, 'paymentReturn'])->name('payment.return.vnpay');
Route::post('/thanh-toan/ipn/vnpay', [BookingController::class, 'paymentIpn'])->name('payment.ipn.vnpay');
Route::post('/thanh-toan/ipn/sepay', [BookingController::class, 'sePayWebhook'])->name('payment.ipn.sepay');
Route::post('/api/v1/check-payment', [BookingController::class, 'sePayWebhook'])->name('payment.sepay.webhook');
Route::get('/thanh-toan/{booking}', [BookingController::class, 'paymentPage'])->name('bookings.payment');
Route::post('/thanh-toan/{booking}', [BookingController::class, 'confirmPayment'])->name('bookings.payment.confirm');
Route::get('/thanh-toan-demo/{code}', function (string $code) {
    $booking = collect(session('demo_bookings', []))->firstWhere('code', $code);

    abort_if($booking === null, 404);

    return view('payment-demo', [
        'title' => 'Thanh toán SePay - Beta Cinemas',
        'booking' => $booking,
    ]);
})->name('booking.demo.payment');
Route::post('/thanh-toan-demo/{code}', function (string $code) {
    $bookings = collect(session('demo_bookings', []))
        ->map(function (array $booking) use ($code) {
            if (($booking['code'] ?? '') === $code) {
                $booking['status'] = 'Đã thanh toán';
            }

            return $booking;
        })
        ->values()
        ->all();

    session(['demo_bookings' => $bookings]);

    return redirect()
        ->route('account.demo', ['tab' => 'history'])
        ->with('status', 'Đã mô phỏng thanh toán SePay thành công cho đơn vé ' . $code . '.');
})->name('booking.demo.payment.confirm');

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
        return redirect()->route('account.demo');
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
            ->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])
            ->withInput(['email' => $email]);
    }

    if (($user->status ?? true) === false) {
        session()->forget(['demo_user', 'admin_authenticated', 'admin_email', 'admin_user_id']);

        return redirect()
            ->to(route('auth.login.form') . '#login')
            ->withErrors(['email' => 'Tài khoản đã bị khóa.'])
            ->withInput(['email' => $email]);
    }

    session(['demo_user' => betaDemoUserSessionPayload($user)]);

    return redirect()->route('account.demo');
})->name('auth.demo.login');

Route::get('/dang-nhap', function () {
    $siteData = betaSiteData();

    return view('auth', [
        'title' => 'Đăng nhập - Beta Cinemas',
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
            ->withErrors(['email' => 'Email này chưa được đăng ký.'])
            ->withInput(['email' => $email]);
    }

    if (($user->status ?? true) === false) {
        return back()
            ->withErrors(['email' => 'Tài khoản đã bị khóa, không thể đặt lại mật khẩu.'])
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
            "Mã OTP đặt lại mật khẩu Beta Cinemas của bạn là: {$code}\n\nMã này hết hạn sau 10 phút.",
            function ($message) use ($email): void {
                $message->to($email)->subject('Mã OTP đặt lại mật khẩu Beta Cinemas');
            }
        );
    } catch (Throwable) {
        PasswordResetOtp::query()
            ->where('email', $email)
            ->whereNull('used_at')
            ->delete();

        return back()
            ->withErrors(['email' => 'Không gửi được email OTP. Vui lòng thử lại sau.'])
            ->withInput(['email' => $email]);
    }

    return redirect()
        ->route('password.reset.form', ['email' => $email])
        ->with('status', 'Mã OTP đã được gửi về email của bạn.');
})->name('password.otp.send');

Route::get('/dat-lai-mat-khau', function (Request $request) {
    return view('password-reset', [
        'title' => 'Đặt lại mật khẩu | Beta Cinemas',
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
            ->withErrors(['otp' => 'Mã OTP không tồn tại hoặc đã hết hạn.'])
            ->withInput(['email' => $email]);
    }

    if (($otp->attempts ?? 0) >= 5) {
        $otp->forceFill(['used_at' => now()])->save();

        return back()
            ->withErrors(['otp' => 'Mã OTP đã bị khóa do nhập sai quá nhiều lần. Vui lòng gửi mã mới.'])
            ->withInput(['email' => $email]);
    }

    if (! Hash::check($data['otp'], (string) $otp->code_hash)) {
        $otp->increment('attempts');

        return back()
            ->withErrors(['otp' => 'Mã OTP không đúng.'])
            ->withInput(['email' => $email]);
    }

    $user = User::query()->where('email', $email)->first();

    if (! $user || ($user->status ?? true) === false) {
        return back()
            ->withErrors(['email' => 'Tài khoản không tồn tại hoặc đã bị khóa.'])
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
        ->with('status', 'Đã đổi mật khẩu. Vui lòng đăng nhập lại.');
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

    return redirect()->route('account.demo');
})->name('auth.demo.register');

Route::get('/dang-ky', function () {
    $siteData = betaSiteData();

    return view('auth', [
        'title' => 'Đăng ký - Beta Cinemas',
        'mode' => 'register',
        'topLinks' => betaTopLinks($siteData),
        'navItems' => betaResolvedNavItems($siteData),
        'footer' => $siteData['footer'] ?? [],
    ]);
})->name('auth.register.form');

Route::get('/dang-xuat', function () {
    session()->forget('demo_user');

    return redirect('/');
})->name('auth.demo.logout');

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
                        ? 'Hết hạn'
                        : ($booking->payment_status === 'paid' ? 'Đã thanh toán' : 'Chờ thanh toán'),
                    'is_expired' => $booking->booking_status === 'expired',
                    'is_pending_payment' => $booking->booking_status !== 'expired' && $booking->payment_status !== 'paid',
                    'payment_url' => $booking->booking_status !== 'expired'
                        ? route('bookings.payment', ['booking' => (string) $booking->getKey()], false)
                        : null,
                    'created_at' => $booking->created_at?->format('d/m/Y H:i') ?? '',
                ];
            });
    }

    $sessionBookings = collect(session('demo_bookings', []))
        ->map(function (array $booking) {
            $status = (string) ($booking['status'] ?? '');
            $isPaid = str_contains($status, 'Đã thanh toán') || str_contains($status, 'Da thanh toan');

            return array_merge($booking, [
                'is_pending_payment' => ! $isPaid,
                'payment_url' => !empty($booking['code'])
                    ? route('booking.demo.payment', ['code' => $booking['code']], false)
                    : null,
            ]);
        });

    return view('account', [
        'title' => 'Tài khoản | Beta Cinemas',
        'activeTab' => $activeTab,
        'bookings' => $sessionBookings->concat($bookings)->values()->all(),
    ]);
})->name('account.demo');

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
                ->withErrors(['email' => 'Email này đã được sử dụng bởi tài khoản khác.'])
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
        ->route('account.demo', ['tab' => 'profile'])
        ->with('status', 'Đã cập nhật thông tin tài khoản.');
})->name('account.demo.update');

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
            ->withErrors(['email' => 'Thông tin đăng nhập quản trị không đúng.'])
            ->withInput();
    }

    if (($admin->status ?? true) === false) {
        return back()
            ->withErrors(['email' => 'Tài khoản quản trị đã bị khóa.'])
            ->withInput();
    }

    if (($admin->role ?? 'user') !== 'admin') {
        return back()
            ->withErrors(['email' => 'Tài khoản chưa có quyền quản trị.'])
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

    return redirect()->route('admin.login')->with('status', 'Đã đăng xuất quản trị.');
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

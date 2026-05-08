<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Seat;
use App\Models\Showtime;
use App\Services\MovieCatalog;
use Illuminate\Http\Request;
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

        if ($label === 'LỊCH CHIẾU THEO RẠP' || $label === 'Lá»ŠCH CHIáº¾U THEO Ráº P') {
            $item['href'] = route('schedule.index');
        } elseif ($label === 'PHIM') {
            $item['href'] = route('movies.index');
        } elseif ($label === 'THÀNH VIÊN' || $label === 'THÃ€NH VIÃŠN') {
            $item['href'] = route('account.demo');
        } else {
            $item['href'] = '#';
        }

        return $item;
    })->all();
}

function betaMergedMovies(array $siteData): array
{
    return app(MovieCatalog::class)->mergedMovies($siteData, betaTrackerMovies());
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

function betaTrackerSourcePath(string $file): string
{
    return 'D:\\My Web Sites\\beta\\betacinemas.vn\\' . ltrim(str_replace('/', '\\', $file), '\\');
}

function betaTrackerAssetUrl(string $path): string
{
    return asset('beta-mirror/' . ltrim(str_replace('\\', '/', $path), '/'));
}

function betaTrackerExternalUrl(string $path): string
{
    return 'https://betacinemas.vn/' . ltrim($path, '/');
}

function betaTrackerRouteMap(): array
{
    return [
        'home.html' => url('/'),
        'lich-chieu.html' => route('schedule.index', [], false),
        'phim.html' => route('movies.index', [], false),
        'thong-tin-rap.html' => route('cinemas.info', [], false),
        'gia-ve.html' => route('prices.index', [], false),
        'tin-moi-va-uu-dai.html' => route('promotions.index', [], false),
        'nhuong-quyen.html' => route('franchise.index', [], false),
        'login-2.html#thongtintaikhoan' => route('member.index', [], false),
        'login.html#login' => route('auth.login.form', [], false) . '#login',
        'login.html#register' => route('auth.register.form', [], false) . '#register',
    ];
}

function betaTrackerPageHtml(string $file): string
{
    $sourcePath = betaTrackerSourcePath($file);

    abort_unless(is_readable($sourcePath), 404);

    $html = file_get_contents($sourcePath);

    abort_if($html === false, 404);

    $assetReplacements = [
        'href="Assets/' => 'href="' . betaTrackerAssetUrl('Assets') . '/',
        "href='Assets/" => "href='" . betaTrackerAssetUrl('Assets') . '/',
        'src="Assets/' => 'src="' . betaTrackerAssetUrl('Assets') . '/',
        "src='Assets/" => "src='" . betaTrackerAssetUrl('Assets') . '/',
        'href="assets/' => 'href="' . betaTrackerAssetUrl('Assets/assets') . '/',
        "href='assets/" => "href='" . betaTrackerAssetUrl('Assets/assets') . '/',
        'src="assets/' => 'src="' . betaTrackerAssetUrl('Assets/assets') . '/',
        "src='assets/" => "src='" . betaTrackerAssetUrl('Assets/assets') . '/',
        'href="fonts/' => 'href="' . betaTrackerAssetUrl('fonts') . '/',
        "href='fonts/" => "href='" . betaTrackerAssetUrl('fonts') . '/',
        'src="fonts/' => 'src="' . betaTrackerAssetUrl('fonts') . '/',
        "src='fonts/" => "src='" . betaTrackerAssetUrl('fonts') . '/',
        'href="favicon-' => 'href="' . betaTrackerAssetUrl('favicon-'),
        "href='favicon-" => "href='" . betaTrackerAssetUrl('favicon-'),
        'src="favicon-' => 'src="' . betaTrackerAssetUrl('favicon-'),
        "src='favicon-" => "src='" . betaTrackerAssetUrl('favicon-'),
    ];

    $html = str_replace(array_keys($assetReplacements), array_values($assetReplacements), $html);
    $html = str_replace('../files.betacorp.vn/', 'https://files.betacorp.vn/', $html);
    $html = str_replace('..\\files.betacorp.vn\\', 'https://files.betacorp.vn/', $html);

    foreach (betaTrackerRouteMap() as $from => $to) {
        $html = str_replace($from, $to, $html);
    }

    $html = preg_replace_callback('/\b(href|src)=("|\')(?!https?:\/\/|\/|#|javascript:|mailto:|tel:)([^"\']+)\2/i', function (array $matches) {
        return $matches[1] . '=' . $matches[2] . betaTrackerExternalUrl($matches[3]) . $matches[2];
    }, $html);

    $html = preg_replace_callback("/RedirectUrl\\('([^']+)'\\)/", function (array $matches) {
        return "RedirectUrl('" . betaTrackerExternalUrl($matches[1]) . "')";
    }, $html);

    return $html;
}

function betaTrackerAuthPageHtml(string $mode = 'login'): string
{
    $html = betaTrackerPageHtml('login.html');

    $html = str_replace(
        "        //Add Enter\r\n        var input = document.getElementById(\"txtLoginCaptcha\");\r\n        input.addEventListener(\"keyup\", function (event) {\r\n            event.preventDefault();\r\n            if (event.keyCode === 13) {\r\n                document.getElementById(\"btnLogin\").click();\r\n            }\r\n        });",
        "        //Add Enter\r\n        var input = document.getElementById(\"txtLoginPassword\");\r\n        if (input) {\r\n            input.addEventListener(\"keyup\", function (event) {\r\n                event.preventDefault();\r\n                if (event.keyCode === 13) {\r\n                    document.getElementById(\"btnLogin\").click();\r\n                }\r\n            });\r\n        }",
        $html
    );

    $defaultTab = $mode === 'register' ? 'register' : 'login';
    $loginUrl = route('auth.demo.login', [], false);
    $registerUrl = route('auth.demo.register', [], false);
    $defaultTabJson = json_encode($defaultTab, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $loginUrlJson = json_encode($loginUrl, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $registerUrlJson = json_encode($registerUrl, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    $forgotMessage = 'Tính năng quên mật khẩu chưa nối backend PHP. Hiện tại bạn dùng tab đăng nhập/đăng ký demo trước.';

    $forgotMessageJson = json_encode($forgotMessage, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

    $overrideScript = <<<HTML
<script>
(function () {
    var defaultTab = {$defaultTabJson};
    var loginUrl = {$loginUrlJson};
    var registerUrl = {$registerUrlJson};
    var forgotMessage = {$forgotMessageJson};

    function isEmail(value) {
        return /^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/.test(value);
    }

    function closeFancy() {
        if (window.jQuery && jQuery.fancybox && typeof jQuery.fancybox.close === 'function') {
            jQuery.fancybox.close();
        }
    }

    window.login = function () {
        var email = (document.getElementById('txtLoginName') || {}).value || '';
        var password = (document.getElementById('txtLoginPassword') || {}).value || '';

        email = email.trim();

        if (!email) {
            alert('Vui lòng nhập email!');
            document.getElementById('txtLoginName').focus();
            return;
        }

        if (!isEmail(email)) {
            alert('Email chưa đúng định dạng!');
            document.getElementById('txtLoginName').focus();
            return;
        }

        if (!password) {
            alert('Vui lòng nhập mật khẩu!');
            document.getElementById('txtLoginPassword').focus();
            return;
        }

        window.location.href = loginUrl + '?email=' + encodeURIComponent(email);
    };

    window.dangKy = function () {
        var name = ((document.getElementById('txtName') || {}).value || '').trim();
        var email = ((document.getElementById('txtEmail') || {}).value || '').trim();
        var password = (document.getElementById('txtMatKhau') || {}).value || '';
        var confirmPassword = (document.getElementById('txtXacNhanMatKhau') || {}).value || '';
        var birthday = ((document.getElementById('txtNgaySinh') || {}).value || '').trim();
        var phone = ((document.getElementById('txtDienThoai') || {}).value || '').trim();
        var accepted = !!((document.getElementById('chk') || {}).checked);

        if (!name) {
            alert('Vui lòng nhập họ tên!');
            document.getElementById('txtName').focus();
            return;
        }

        if (!email) {
            alert('Vui lòng nhập email!');
            document.getElementById('txtEmail').focus();
            return;
        }

        if (!isEmail(email)) {
            alert('Email chưa đúng định dạng!');
            document.getElementById('txtEmail').focus();
            return;
        }

        if (!password) {
            alert('Vui lòng nhập mật khẩu!');
            document.getElementById('txtMatKhau').focus();
            return;
        }

        if (!confirmPassword) {
            alert('Vui lòng xác nhận lại mật khẩu!');
            document.getElementById('txtXacNhanMatKhau').focus();
            return;
        }

        if (password !== confirmPassword) {
            alert('Mật khẩu xác nhận lại chưa chính xác!');
            document.getElementById('txtXacNhanMatKhau').focus();
            return;
        }

        if (!birthday) {
            alert('Vui lòng nhập ngày sinh!');
            document.getElementById('txtNgaySinh').focus();
            return;
        }

        if (!phone) {
            alert('Vui lòng nhập số điện thoại!');
            document.getElementById('txtDienThoai').focus();
            return;
        }

        if (!accepted) {
            alert('Bạn cần đồng ý với chính sách và điều khoản sử dụng!');
            return;
        }

        window.location.href = registerUrl + '?name=' + encodeURIComponent(name) + '&email=' + encodeURIComponent(email);
    };

    window.forgotpass = function () {
        alert(forgotMessage);
        closeFancy();
    };

    document.addEventListener('DOMContentLoaded', function () {
        [
            'captchalogin',
            'captcharegister',
            'captchachangepass',
            'txtLoginCaptcha',
            'txtMaXacThuc',
            'txtChangePassCaptcha'
        ].forEach(function (id) {
            var element = document.getElementById(id);
            if (!element) {
                return;
            }

            var row = element.closest('.form-group');
            if (row) {
                row.style.display = 'none';
            }
        });

        if (!window.location.hash && typeof window.activaTab === 'function') {
            window.activaTab(defaultTab);
        }

        closeFancy();
        window.setTimeout(closeFancy, 100);
        window.setTimeout(closeFancy, 500);
    });
})();
</script>
HTML;

    $html = str_replace('</body>', $overrideScript . "\n</body>", $html);

    return $html;
}

function betaTrackerTopBarMenuHtml(): string
{
    $demoUser = session('demo_user');

    if (is_array($demoUser) && !empty($demoUser['name'])) {
        $name = e((string) $demoUser['name']);
        $accountUrl = e(route('account.demo', [], false));
        $logoutUrl = e(route('auth.demo.logout', [], false));

        return <<<HTML
<ul class="list-unstyled list-inline pull-right tracker-user-menu" style="margin-bottom: 4px;margin-top: 4px;">
    <li class="tracker-user-menu__greeting"><a href="{$accountUrl}">Xin chào: {$name} <i class="fa fa-angle-down"></i></a></li>
    <li class="tracker-user-menu__logout" style="border-left: 1px solid; padding-left: 10px !important;"><a href="{$logoutUrl}" aria-label="Đăng xuất"><i class="fa fa-sign-out"></i></a></li>
</ul>
HTML;
    }

    $loginUrl = e(route('auth.login.form', [], false) . '#login');
    $registerUrl = e(route('auth.register.form', [], false) . '#register');

    return <<<HTML
<ul class="list-unstyled list-inline pull-right tracker-user-menu" style="margin-bottom: 4px;margin-top: 4px;">
    <li class="tracker-user-menu__login"><a href="{$loginUrl}">Đăng nhập</a></li>
    <li class="tracker-user-menu__register" style="border-left: 1px solid; padding-left: 10px !important;"><a href="{$registerUrl}">Đăng ký</a></li>
</ul>
HTML;
}

function betaTrackerWrappedContentHtml(string $contentHtml, string $title = 'Beta Cinemas', string $shellFile = 'chi-tiet-phim3fbb.html'): string
{
    $html = betaTrackerPageHtml($shellFile);

    $html = preg_replace('/<title>\s*.*?\s*<\/title>/is', '<title>' . e($title) . '</title>', $html) ?? $html;
    $html = preg_replace(
        '/<ul class="list-unstyled list-inline pull-right" style="margin-bottom: 4px;margin-top: 4px;">.*?<\/ul>/is',
        betaTrackerTopBarMenuHtml(),
        $html,
        1
    ) ?? $html;

    $topBarStyle = <<<'HTML'
<style>
    .tracker-user-menu .fa-sign-out {
        font-size: 20px;
        line-height: 1;
        vertical-align: middle;
    }
    .tracker-user-menu__greeting a {
        white-space: nowrap;
    }
</style>
</head>
HTML;
    $html = str_replace('</head>', $topBarStyle, $html);

    $startMarker = '<div class="margin-none">';
    $endMarker = '<!-- BEGIN PRE-FOOTER -->';
    $start = strpos($html, $startMarker);
    $end = strpos($html, $endMarker);

    if ($start === false || $end === false || $end <= $start) {
        return $html;
    }

    return substr($html, 0, $start)
        . $contentHtml
        . "\n      "
        . substr($html, $end);
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
    $topScheduleDates = $siteData['defaultScheduleDates'] ?? [];
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
        ->map(fn (array $date): string => trim(($date['label'] ?? '') . ($date['suffix'] ?? '')))
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
        $scheduleDates = $movie['scheduleDates'] ?? ($siteData['defaultScheduleDates'] ?? []);
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

        $activeGroups = $movie['showtimeGroups'] ?? ($siteData['defaultShowtimeGroups'] ?? []);
        foreach ($scheduleByDate as $date) {
            $key = trim(($date['label'] ?? '') . ($date['suffix'] ?? ''));
            if ($key === $selectedDate) {
                $activeGroups = $date['groups'] ?? $activeGroups;
                break;
            }
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
    $movie['scheduleDates'] = $movie['scheduleDates'] ?? ($siteData['defaultScheduleDates'] ?? []);
    $movie['showtimeGroups'] = $movie['showtimeGroups'] ?? ($siteData['defaultShowtimeGroups'] ?? []);
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

    $selectedCinema = trim((string) $request->query('cinema', 'Beta Thái Nguyên'));
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

    $contentHtml = view('seat-selection-content', [
        'movie' => $movie,
        'selectedCinema' => $selectedCinema,
        'selectedDate' => $selectedDate,
        'selectedTime' => $selectedTime,
        'selectedFormat' => $selectedFormat,
        'seatRows' => $seatRows,
        'soldSeats' => $soldSeats,
        'heldSeats' => $heldSeats,
        'reservedSeats' => $reservedSeats,
        'preselectedSeats' => $preselectedSeats,
    ])->render();

    return view('tracker-import', [
        'pageHtml' => betaTrackerWrappedContentHtml($contentHtml, 'Đặt vé - ' . ($movie['title'] ?? 'Beta Cinemas')),
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
        'cinema' => ['required', 'string', 'max:120'],
        'show_date' => ['required', 'string', 'max:80'],
        'show_time' => ['required', 'string', 'max:40'],
        'format' => ['required', 'string', 'max:80'],
        'seats' => ['required', 'string', 'max:200'],
    ]);

    $seats = collect(explode(',', $validated['seats']))
        ->map(fn (string $seat): string => trim($seat))
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
        'cinema' => $validated['cinema'],
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
    return view('tracker-import', [
        'pageHtml' => betaTrackerPageHtml('thong-tin-rap.html'),
    ]);
})->name('cinemas.info');

Route::get('/gia-ve', function () {
    return view('tracker-import', [
        'pageHtml' => betaTrackerPageHtml('gia-ve.html'),
    ]);
})->name('prices.index');

Route::get('/tin-moi-va-uu-dai', function () {
    return view('tracker-import', [
        'pageHtml' => betaTrackerPageHtml('tin-moi-va-uu-dai.html'),
    ]);
})->name('promotions.index');

Route::get('/nhuong-quyen', function () {
    return view('tracker-import', [
        'pageHtml' => betaTrackerPageHtml('nhuong-quyen.html'),
    ]);
})->name('franchise.index');

Route::get('/thanh-vien', function () {
    if (session()->has('demo_user')) {
        return redirect()->route('account.demo');
    }

    return redirect()->to(route('auth.login.form') . '#login');
})->name('member.index');

Route::get('/demo-auth/login', function (Request $request) {
    $name = trim((string) $request->query('name', ''));
    $email = trim((string) $request->query('email', ''));

    if ($name === '') {
        if ($email !== '' && str_contains($email, '@')) {
            $name = ucfirst((string) str($email)->before('@'));
        } else {
            $name = 'Beta Member';
        }
    }

    session([
        'demo_user' => [
            'name' => $name,
            'email' => $email !== '' ? $email : 'member@betacinemas.vn',
        ],
    ]);

    return redirect()->route('account.demo');
})->name('auth.demo.login');

Route::get('/dang-nhap', function () {
    return view('tracker-import', [
        'title' => 'Đăng nhập - Beta Cinemas',
        'pageHtml' => betaTrackerAuthPageHtml('login'),
    ]);
})->name('auth.login.form');

Route::get('/demo-auth/register', function (Request $request) {
    $name = trim((string) $request->query('name', 'Beta Member'));
    $email = trim((string) $request->query('email', 'member@betacinemas.vn'));

    session([
        'demo_user' => [
            'name' => $name !== '' ? $name : 'Beta Member',
            'email' => $email !== '' ? $email : 'member@betacinemas.vn',
        ],
    ]);

    return redirect()->route('account.demo');
})->name('auth.demo.register');

Route::get('/dang-ky', function () {
    return view('tracker-import', [
        'title' => 'Đăng ký - Beta Cinemas',
        'pageHtml' => betaTrackerAuthPageHtml('register'),
    ]);
})->name('auth.register.form');

Route::get('/dang-xuat', function () {
    session()->forget('demo_user');

    return redirect('/');
})->name('auth.demo.logout');

Route::get('/tai-khoan', function (Request $request) {
    if (!session()->has('demo_user')) {
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
        $bookings = Booking::query()
            ->with(['showtime.movie', 'showtime.room.cinema', 'seats.seat'])
            ->where('customer_email', $demoEmail)
            ->orderByDesc('created_at')
            ->get()
            ->map(function (Booking $booking) {
                $showtime = $booking->showtime;
                $movie = $showtime?->movie;
                $room = $showtime?->room;
                $cinema = $room?->cinema;

                return [
                    'booking_id' => (string) $booking->getKey(),
                    'code' => $booking->qr_code,
                    'movie_title' => $movie?->title ?? 'Beta Cinemas',
                    'cinema' => $cinema?->name ?? '',
                    'show_date' => $showtime?->start_time?->format('d/m/Y') ?? '',
                    'show_time' => $showtime?->start_time?->format('H:i') ?? '',
                    'seats' => $booking->seats
                        ->map(fn (BookingSeat $bookingSeat) => $bookingSeat->seat?->seat_number)
                        ->filter()
                        ->values()
                        ->all(),
                    'total' => (int) $booking->total_price,
                    'status' => $booking->payment_status === 'paid' ? 'Đã thanh toán' : 'Chờ thanh toán',
                    'is_pending_payment' => $booking->payment_status !== 'paid',
                    'payment_url' => route('bookings.payment', ['booking' => (string) $booking->getKey()], false),
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

    if ($credentials['email'] !== $adminEmail || $credentials['password'] !== $adminPassword) {
        return back()
            ->withErrors(['email' => 'Thong tin dang nhap admin khong dung.'])
            ->withInput();
    }

    session([
        'admin_authenticated' => true,
        'admin_email' => $credentials['email'],
    ]);

    return redirect()->route('admin.dashboard');
})->name('admin.login.submit');

Route::post('/admin/logout', function () {
    session()->forget(['admin_authenticated', 'admin_email']);

    return redirect()->route('admin.login')->with('status', 'Da dang xuat admin.');
})->name('admin.logout');

Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');

    Route::get('/movies', [AdminController::class, 'movies'])->name('movies.index');
    Route::get('/movies/create', [AdminController::class, 'createMovie'])->name('movies.create');
    Route::post('/movies', [AdminController::class, 'storeMovie'])->name('movies.store');
    Route::get('/movies/{movie}/edit', [AdminController::class, 'editMovie'])->name('movies.edit');
    Route::put('/movies/{movie}', [AdminController::class, 'updateMovie'])->name('movies.update');
    Route::delete('/movies/{movie}', [AdminController::class, 'deleteMovie'])->name('movies.delete');

    Route::get('/cinemas', [AdminController::class, 'cinemas'])->name('cinemas.index');
    Route::post('/cinemas', [AdminController::class, 'storeCinema'])->name('cinemas.store');
    Route::put('/cinemas/{cinema}', [AdminController::class, 'updateCinema'])->name('cinemas.update');
    Route::delete('/cinemas/{cinema}', [AdminController::class, 'deleteCinema'])->name('cinemas.delete');
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

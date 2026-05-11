<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\AdminController;
use App\Models\Booking;
use App\Models\BookingSeat;
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
            'title' => 'PhÃ­ PhÃ´ng: Quá»· MÃ¡u Rá»«ng ThiÃªng',
            'genre' => 'Kinh dá»‹, Giáº­t gÃ¢n',
            'duration' => 120,
            'label' => 'C16',
            'tag' => 'HOT',
            'poster' => 'https://files.betacorp.vn/media/images/2026/03/26/anh-chup-man-hinh-2026-03-26-114032-114119-260326-54.png',
            'buyUrl' => '',
            'description' => 'PhÃ­ PhÃ´ng, loÃ i quá»· khÃ¡t mÃ¡u trong truyá»n thuyáº¿t dÃ¢n gian cá»§a Ä‘á»“ng bÃ o miá»n nÃºi gÃ¢y Ã¡m áº£nh bao Ä‘á»i nay. Phim xoay quanh CÃ²n (Kiá»u Minh Tuáº¥n) vÃ  DÆ°Æ¡ng (Minh Anh), hai phÃ¡p sÆ° táº­p sá»± lÃªn nÃºi cá»©u ngÆ°á»i máº¹ Ä‘ang bá»‹ lá»i nguyá»n PhÃ­ PhÃ´ng Ä‘Ã¡nh gá»¥c.',
            'releaseDate' => '20/04/2026',
            'language' => 'Tiáº¿ng Viá»‡t',
            'trailer' => 'https://www.youtube.com/embed/LDvCnwE6TtA',
            'details' => [
                ['label' => 'Äáº¡o diá»…n', 'value' => 'Äá»— Quá»‘c Trung'],
                ['label' => 'Diá»…n viÃªn', 'value' => 'Kiá»u Minh Tuáº¥n, Nina Nutthacha Padovan, Diá»‡p Báº£o Ngá»c, ÄoÃ n Minh Anh, NSÆ¯T Háº¡nh ThuÃ½,...'],
                ['label' => 'Thá»ƒ loáº¡i', 'value' => 'Kinh dá»‹, Giáº­t gÃ¢n'],
                ['label' => 'Thá»i lÆ°á»£ng', 'value' => '120 phÃºt'],
                ['label' => 'NgÃ´n ngá»¯', 'value' => 'Tiáº¿ng Viá»‡t'],
                ['label' => 'NgÃ y khá»Ÿi chiáº¿u', 'value' => '20/04/2026'],
            ],
        ],
        [
            'id' => 'anh-hung',
            'section' => 'now-showing',
            'title' => 'Anh HÃ¹ng',
            'genre' => 'TÃ¢m lÃ½, Gia Ä‘Ã¬nh',
            'duration' => 122,
            'label' => 'C13',
            'tag' => 'HOT',
            'poster' => 'https://files.betacorp.vn/media/images/2026/03/31/400wx633h-113142-310326-81.jpg',
            'buyUrl' => '',
            'description' => 'CÃ¢u chuyá»‡n phim theo chÃ¢n HÃ¹ng (ThÃ¡i HÃ²a) - ngÆ°á»i cha Ä‘Æ¡n thÃ¢n kiÃªm tÃ i xáº¿ taxi vÃ  Ä‘á»“ng nghiá»‡p hÃ£ng xe lÃ  Tuáº¥n (VÃµ Táº¥n PhÃ¡t) bá»‹ cuá»‘n vÃ o má»™t phi vá»¥ lá»«a Ä‘áº£o tá»« thiá»‡n tiá»n tá»‰ trong khi sinh máº¡ng cÃ´ con gÃ¡i nhá» cá»§a anh Ä‘ang náº±m gá»n trong tay tá»­ tháº§n.',
            'releaseDate' => '24/04/2026',
            'language' => 'Tiáº¿ng Viá»‡t',
            'trailer' => 'https://www.youtube.com/embed/P74tpiZ8kuU',
            'details' => [
                ['label' => 'Äáº¡o diá»…n', 'value' => 'VÃµ Tháº¡ch Tháº£o'],
                ['label' => 'Diá»…n viÃªn', 'value' => 'ThÃ¡i HoÃ , VÃµ Táº¥n PhÃ¡t, ÄoÃ n Tháº¿ Vinh, PhÆ°Æ¡ng Thanh, Há»“ng Ãnh, NSÆ¯T LÃª Thiá»‡n, HoÃ ng Minh Triáº¿t, Gia Tuá»‡...'],
                ['label' => 'Thá»ƒ loáº¡i', 'value' => 'TÃ¢m lÃ½, Gia Ä‘Ã¬nh'],
                ['label' => 'Thá»i lÆ°á»£ng', 'value' => '122 phÃºt'],
                ['label' => 'NgÃ´n ngá»¯', 'value' => 'Tiáº¿ng Viá»‡t'],
                ['label' => 'NgÃ y khá»Ÿi chiáº¿u', 'value' => '24/04/2026'],
            ],
        ],
        [
            'id' => 'dai-tiec-trang-mau-8',
            'section' => 'now-showing',
            'title' => 'Äáº¡i Tiá»‡c TrÄƒng MÃ¡u 8',
            'genre' => 'HÃ i hÆ°á»›c, Kinh dá»‹',
            'duration' => 130,
            'label' => 'C16',
            'tag' => 'HOT',
            'poster' => 'https://files.betacorp.vn/media/images/2026/04/16/400x633-102941-160426-44.jpg',
            'buyUrl' => '',
            'description' => 'Äáº¡i Tiá»‡c TrÄƒng MÃ¡u 8 theo chÃ¢n má»™t vá»‹ Ä‘áº¡o diá»…n hay bá»‹ coi thÆ°á»ng trong dá»± Ã¡n thá»­ thÃ¡ch nháº¥t Ä‘á»i Ã´ng: thá»±c hiá»‡n má»™t bá»™ phim dÃ i 35 phÃºt chá»‰ vá»›i má»™t cÃº mÃ¡y.',
            'releaseDate' => '24/04/2026',
            'language' => 'Tiáº¿ng Viá»‡t',
            'trailer' => 'https://www.youtube.com/embed/NZ9-wGErh4o',
            'details' => [
                ['label' => 'Äáº¡o diá»…n', 'value' => 'Phan Gia Nháº­t Linh'],
                ['label' => 'Diá»…n viÃªn', 'value' => 'VÃ¢n SÆ¡n, LÃª KhÃ¡nh, Miu LÃª, LiÃªn Bá»‰nh PhÃ¡t, Quá»‘c KhÃ¡nh, Quá»³nh LÃ½, LÃ¢m Thanh Má»¹, Quang Minh, Há»©a VÄ© VÄƒn, Há»“ng Ãnh, NSÆ¯T Äá»©c KhuÃª, Charlie Nguyá»…n...'],
                ['label' => 'Thá»ƒ loáº¡i', 'value' => 'HÃ i hÆ°á»›c, Kinh dá»‹'],
                ['label' => 'Thá»i lÆ°á»£ng', 'value' => '130 phÃºt'],
                ['label' => 'NgÃ´n ngá»¯', 'value' => 'Tiáº¿ng Viá»‡t'],
                ['label' => 'NgÃ y khá»Ÿi chiáº¿u', 'value' => '24/04/2026'],
            ],
        ],
        [
            'id' => 'heo-nam-mong',
            'section' => 'now-showing',
            'title' => 'Heo NÄƒm MÃ³ng',
            'genre' => 'Kinh dá»‹',
            'duration' => 103,
            'label' => 'C18',
            'tag' => '',
            'poster' => 'https://files.betacorp.vn/media/images/2026/04/08/anh-chup-man-hinh-2026-04-08-161626-161707-080426-39.png',
            'buyUrl' => '',
            'description' => 'Dá»±a trÃªn truyá»n thuyáº¿t rÃ¹ng rá»£n vá» "CÃ´ NÄƒm Há»£i" vÃ  linh há»“n bá»‹ máº¯c káº¹t trong thÃ¢n xÃ¡c heo.',
            'releaseDate' => '24/04/2026',
            'language' => 'Tiáº¿ng Viá»‡t',
            'trailer' => 'https://www.youtube.com/embed/ShknvbpzZxg',
            'details' => [
                ['label' => 'Äáº¡o diá»…n', 'value' => 'VÃµ Thanh HÃ²a'],
                ['label' => 'Diá»…n viÃªn', 'value' => 'VÃµ Táº¥n PhÃ¡t, Tráº§n Ngá»c VÃ ng, Nháº­t Ã, Thanh Thá»§y,..'],
                ['label' => 'Thá»ƒ loáº¡i', 'value' => 'Kinh dá»‹'],
                ['label' => 'Thá»i lÆ°á»£ng', 'value' => '103 phÃºt'],
                ['label' => 'NgÃ´n ngá»¯', 'value' => 'Tiáº¿ng Viá»‡t'],
                ['label' => 'NgÃ y khá»Ÿi chiáº¿u', 'value' => '24/04/2026'],
            ],
        ],
        [
            'id' => 'trum-so',
            'section' => 'now-showing',
            'title' => 'TrÃ¹m SÃ²',
            'genre' => 'HÃ i hÆ°á»›c',
            'duration' => 105,
            'label' => 'K',
            'tag' => '',
            'poster' => 'https://files.betacorp.vn/media/images/2026/04/10/400x633-1-141724-100426-34.jpg',
            'buyUrl' => '',
            'description' => 'á»ž LÃ ng Sá»©a Äá» - má»™t ngÃ´i lÃ ng nhá» xa xÃ´i heo hÃºt, háº¡n hÃ¡n triá»n miÃªn, ngÆ°á»i dÃ¢n ai cÅ©ng nghÃ¨o cÅ©ng khá»•, chá»‰ riÃªng TrÃ¹m SÃ² lÃ  giÃ u ná»©t Ä‘á»‘ Ä‘á»• vÃ¡ch.',
            'releaseDate' => '24/04/2026',
            'language' => 'Tiáº¿ng Viá»‡t',
            'trailer' => 'https://www.youtube.com/embed/QoKBpq_p61Q',
            'details' => [
                ['label' => 'Äáº¡o diá»…n', 'value' => 'Äá»— Äá»©c Thá»‹nh'],
                ['label' => 'Diá»…n viÃªn', 'value' => 'Äá»©c Thá»‹nh, PhÆ°Æ¡ng Nam, Mai PhÆ°Æ¡ng, DoÃ£n Quá»‘c Äam, HoÃ ng TÃ³c DÃ i,...'],
                ['label' => 'Thá»ƒ loáº¡i', 'value' => 'HÃ i hÆ°á»›c'],
                ['label' => 'Thá»i lÆ°á»£ng', 'value' => '105 phÃºt'],
                ['label' => 'NgÃ´n ngá»¯', 'value' => 'Tiáº¿ng Viá»‡t'],
                ['label' => 'NgÃ y khá»Ÿi chiáº¿u', 'value' => '24/04/2026'],
            ],
        ],
        [
            'id' => 'hen-em-ngay-nhat-thuc',
            'section' => 'now-showing',
            'title' => 'Háº¹n Em NgÃ y Nháº­t Thá»±c',
            'genre' => 'TÃ¢m lÃ½, Gia Ä‘Ã¬nh',
            'duration' => 118,
            'label' => 'C16',
            'tag' => '',
            'poster' => 'https://files.betacorp.vn/media/images/2026/03/18/teaser-hennt-cinema-150342-180326-62.jpg',
            'buyUrl' => '',
            'description' => 'NÄƒm 1995, khi Ä‘ang Ä‘á»©ng trÆ°á»›c má»™t quyáº¿t Ä‘á»‹nh quan trá»ng cá»§a cuá»™c Ä‘á»i, Ã‚n báº¥t ngá» bá»‹ kÃ©o trá»Ÿ láº¡i quÃ¡ khá»© bá»Ÿi nhá»¯ng bá»©c thÆ° tÃ¬nh chÆ°a tá»«ng trao tay.',
            'releaseDate' => '30/03/2026',
            'language' => 'Tiáº¿ng Viá»‡t',
            'trailer' => 'https://www.youtube.com/embed/xeuiol66BkA',
            'details' => [
                ['label' => 'Äáº¡o diá»…n', 'value' => 'LÃª Thiá»‡n Viá»…n'],
                ['label' => 'Diá»…n viÃªn', 'value' => 'ÄoÃ n ThiÃªn Ã‚n, KhÆ°Æ¡ng LÃª, NSND LÃª Khanh, Huá»³nh PhÆ°Æ¡ng, NguyÃªn Tháº£o, NSND Kim XuÃ¢n, Thanh SÆ¡n, Há»©a VÄ© VÄƒn, LÃ¢m Vá»¹ Dáº¡, Há»©a Minh Äáº¡t.'],
                ['label' => 'Thá»ƒ loáº¡i', 'value' => 'TÃ¢m lÃ½, Gia Ä‘Ã¬nh'],
                ['label' => 'Thá»i lÆ°á»£ng', 'value' => '118 phÃºt'],
                ['label' => 'NgÃ´n ngá»¯', 'value' => 'Tiáº¿ng Viá»‡t'],
                ['label' => 'NgÃ y khá»Ÿi chiáº¿u', 'value' => '30/03/2026'],
            ],
        ],
        [
            'id' => 'cu-nhay-ky-dieu',
            'section' => 'now-showing',
            'title' => 'CÃº Nháº£y Ká»³ Diá»‡u',
            'genre' => 'Hoáº¡t hÃ¬nh, PhiÃªu lÆ°u',
            'duration' => 105,
            'label' => 'P',
            'tag' => '',
            'poster' => 'https://files.betacorp.vn/media/images/2026/02/26/anh-chup-man-hinh-2026-02-26-151006-151102-260226-84.png',
            'buyUrl' => '',
            'description' => 'CÃ¢u chuyá»‡n xoay quanh Mabel, ná»¯ sinh Ä‘áº¡i há»c 19 tuá»•i vá»›i tÃ¬nh yÃªu mÃ£nh liá»‡t dÃ nh cho Ä‘á»™ng váº­t, Ä‘Ã£ náº¯m báº¯t cÆ¡ há»™i sá»­ dá»¥ng cÃ´ng nghá»‡ cho phÃ©p Ã½ thá»©c â€œnháº£yâ€ vÃ o má»™t chÃº háº£i ly rÃ´-bá»‘t.',
            'releaseDate' => '13/03/2026',
            'language' => 'Tiáº¿ng Viá»‡t',
            'trailer' => 'https://www.youtube.com/embed/CHINiUp2L0g',
            'details' => [
                ['label' => 'Äáº¡o diá»…n', 'value' => 'Daniel Chong'],
                ['label' => 'Diá»…n viÃªn', 'value' => ''],
                ['label' => 'Thá»ƒ loáº¡i', 'value' => 'Hoáº¡t hÃ¬nh, PhiÃªu lÆ°u'],
                ['label' => 'Thá»i lÆ°á»£ng', 'value' => '105 phÃºt'],
                ['label' => 'NgÃ´n ngá»¯', 'value' => 'Tiáº¿ng Viá»‡t'],
                ['label' => 'NgÃ y khá»Ÿi chiáº¿u', 'value' => '13/03/2026'],
            ],
        ],
        [
            'id' => 'michael',
            'section' => 'now-showing',
            'title' => 'Michael',
            'genre' => 'Ã‚m Nháº¡c',
            'duration' => 127,
            'label' => 'K',
            'tag' => '',
            'poster' => 'https://files.betacorp.vn/media/images/2026/04/13/anh-chup-man-hinh-2026-04-13-090338-090425-130426-13.png',
            'buyUrl' => '',
            'description' => 'Michael lÃ  tÃ¡c pháº©m Ä‘iá»‡n áº£nh kháº¯c há»a cuá»™c Ä‘á»i vÃ  di sáº£n cá»§a má»™t trong nhá»¯ng nghá»‡ sÄ© cÃ³ áº£nh hÆ°á»Ÿng nháº¥t mÃ  tháº¿ giá»›i tá»«ng biáº¿t Ä‘áº¿n.',
            'releaseDate' => '22/04/2026',
            'language' => 'Tiáº¿ng Anh',
            'trailer' => 'https://www.youtube.com/embed/I7T5VK3zqbY',
            'details' => [
                ['label' => 'Äáº¡o diá»…n', 'value' => 'Antoine Fuqua'],
                ['label' => 'Diá»…n viÃªn', 'value' => 'Jaafar Jackson, Nia Long, Laura Harrier, Juliano Krue Valdi, cÃ¹ng Miles Teller vÃ  Colman Domingo'],
                ['label' => 'Thá»ƒ loáº¡i', 'value' => 'Ã‚m Nháº¡c'],
                ['label' => 'Thá»i lÆ°á»£ng', 'value' => '127 phÃºt'],
                ['label' => 'NgÃ´n ngá»¯', 'value' => 'Tiáº¿ng Anh'],
                ['label' => 'NgÃ y khá»Ÿi chiáº¿u', 'value' => '22/04/2026'],
            ],
        ],
        [
            'id' => 'phim-shin-cau-be-but-chi',
            'section' => 'now-showing',
            'title' => 'Phim Shin - Cáº­u BÃ© BÃºt ChÃ¬',
            'genre' => 'Hoáº¡t hÃ¬nh, Gia Ä‘Ã¬nh',
            'duration' => 104,
            'label' => 'P',
            'tag' => '',
            'poster' => 'https://files.betacorp.vn/media/images/2026/04/23/poster-shin-2020-4x5-174632-230426-77.png',
            'buyUrl' => '',
            'description' => 'Bá»™ phim xoay quanh má»™t vÆ°Æ¡ng quá»‘c lÆ¡ lá»­ng mang tÃªn Rakuga, tá»“n táº¡i nhá» nguá»“n nÄƒng lÆ°á»£ng Ä‘áº¿n tá»« nhá»¯ng nÃ©t váº½ cá»§a con ngÆ°á»i.',
            'releaseDate' => '01/05/2026',
            'language' => 'Tiáº¿ng Nháº­t',
            'trailer' => 'https://www.youtube.com/embed/KyyoTlt5VJo',
            'details' => [
                ['label' => 'Äáº¡o diá»…n', 'value' => 'Masakazu Hashimoto'],
                ['label' => 'Diá»…n viÃªn', 'value' => 'Akiko Yajima Shin Yumiko Kobayashi, Miki Narahashi,Toshiyuki Morikawa'],
                ['label' => 'Thá»ƒ loáº¡i', 'value' => 'Hoáº¡t hÃ¬nh, Gia Ä‘Ã¬nh'],
                ['label' => 'Thá»i lÆ°á»£ng', 'value' => '104 phÃºt'],
                ['label' => 'NgÃ´n ngá»¯', 'value' => 'Tiáº¿ng Nháº­t'],
                ['label' => 'NgÃ y khá»Ÿi chiáº¿u', 'value' => '01/05/2026'],
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

        if ($label === 'Lá»ŠCH CHIáº¾U THEO Ráº P' || $label === 'LÃ¡Â»Å CH CHIÃ¡ÂºÂ¾U THEO RÃ¡ÂºÂ P') {
            $item['href'] = route('schedule.index');
        } elseif ($label === 'PHIM') {
            $item['href'] = route('movies.index');
        } elseif ($label === 'THÃ€NH VIÃŠN' || $label === 'THÃƒâ‚¬NH VIÃƒÅ N') {
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
    if (!preg_match('/(?:Ã|Â|Æ|Ä|áº|á»|â€)/u', $value)) {
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
        'title' => 'Lá»‹ch chiáº¿u - Beta Cinemas',
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
        ['label' => 'Thá»ƒ loáº¡i', 'value' => $movie['genre'] ?? 'Äang cáº­p nháº­t'],
        ['label' => 'Thá»i lÆ°á»£ng', 'value' => (($movie['duration'] ?? null) ? ($movie['duration'] . ' phÃºt') : 'Äang cáº­p nháº­t')],
        ['label' => 'NgÃ´n ngá»¯', 'value' => $movie['language'] ?? 'Tiáº¿ng Viá»‡t'],
        ['label' => 'NgÃ y khá»Ÿi chiáº¿u', 'value' => $movie['releaseDate'] ?? 'Äang cáº­p nháº­t'],
    ];
    $movie['scheduleDates'] = $movie['scheduleDates'] ?? [];
    $movie['showtimeGroups'] = $movie['showtimeGroups'] ?? [];
    $movie['scheduleByDate'] = $movie['scheduleByDate'] ?? [];
    $movie['showtimes'] = $movie['showtimes'] ?? [];

    return view('movie-detail', [
        'title' => ($movie['title'] ?? 'Chi tiáº¿t phim') . ' - Beta Cinemas',
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
    $selectedFormat = trim((string) $request->query('format', '2D Phá»¥ Ä‘á»'));

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
            ->with('status', 'Vui lÃ²ng Ä‘Äƒng nháº­p trÆ°á»›c khi tiáº¿p tá»¥c Ä‘áº·t vÃ©.');
    }

    $validated = $request->validate([
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
        return back()->withErrors(['seats' => 'Vui lÃ²ng chá»n Ã­t nháº¥t má»™t gháº¿.'])->withInput();
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
        'status' => 'Chá» thanh toÃ¡n',
        'created_at' => now()->format('d/m/Y H:i'),
    ];

    array_unshift($bookings, $booking);
    session(['demo_bookings' => array_slice($bookings, 0, 10)]);

    return redirect()
        ->route('booking.demo.payment', ['code' => $booking['code']])
        ->with('status', 'ÄÃ£ giá»¯ gháº¿ ' . implode(', ', $seats) . ' cho phim ' . ($movie['title'] ?? 'Beta Cinemas') . '. Vui lÃ²ng thanh toÃ¡n VNPay.');
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
        'title' => 'Thanh toÃ¡n SePay - Beta Cinemas',
        'booking' => $booking,
    ]);
})->name('booking.demo.payment');
Route::post('/thanh-toan-demo/{code}', function (string $code) {
    $bookings = collect(session('demo_bookings', []))
        ->map(function (array $booking) use ($code) {
            if (($booking['code'] ?? '') === $code) {
                $booking['status'] = 'ÄÃ£ thanh toÃ¡n';
            }

            return $booking;
        })
        ->values()
        ->all();

    session(['demo_bookings' => $bookings]);

    return redirect()
        ->route('account.demo', ['tab' => 'history'])
        ->with('status', 'ÄÃ£ mÃ´ phá»ng thanh toÃ¡n SePay thÃ nh cÃ´ng cho Ä‘Æ¡n vÃ© ' . $code . '.');
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
    $siteData = betaSiteData();

    return view('auth', [
        'title' => 'Đăng nhập - Beta Cinemas',
        'mode' => 'login',
        'topLinks' => betaTopLinks($siteData),
        'navItems' => betaResolvedNavItems($siteData),
        'footer' => $siteData['footer'] ?? [],
    ]);
})->name('auth.login.form');

Route::get('/demo-auth/register', function (Request $request) {
    $name = trim((string) $request->query('name', 'Beta Member'));
    $email = trim((string) $request->query('email', 'member@betacinemas.vn'));
    $birthday = trim((string) $request->query('birthday', ''));
    $phone = trim((string) $request->query('phone', ''));
    $gender = trim((string) $request->query('gender', ''));

    session([
        'demo_user' => [
            'name' => $name !== '' ? $name : 'Beta Member',
            'email' => $email !== '' ? $email : 'member@betacinemas.vn',
            'birthday' => $birthday,
            'phone' => $phone,
            'gender' => $gender,
        ],
    ]);

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
                        ->map(fn (BookingSeat $bookingSeat) => $bookingSeat->seat?->seat_number)
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
            ->withErrors(['email' => 'ThÃ´ng tin Ä‘Äƒng nháº­p quáº£n trá»‹ khÃ´ng Ä‘Ãºng.'])
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

    return redirect()->route('admin.login')->with('status', 'ÄÃ£ Ä‘Äƒng xuáº¥t quáº£n trá»‹.');
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


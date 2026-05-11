<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminSetting;
use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Movie;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Seat;
use App\Models\Showtime;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $this->releaseExpiredHolds();

        $successfulPaymentBookingIds = Payment::query()
            ->whereIn('status', ['success', 'paid'])
            ->get()
            ->map(fn (Payment $payment) => (string) $payment->booking_id)
            ->filter()
            ->unique()
            ->values()
            ->all();

        $paidBookings = $successfulPaymentBookingIds === []
            ? collect()
            : Booking::query()
                ->where('booking_status', 'booked')
                ->where('payment_status', 'paid')
                ->whereIn('_id', $successfulPaymentBookingIds)
                ->get();
        $recentBookings = Booking::query()->orderByDesc('created_at')->limit(8)->get();

        return view('admin.dashboard', [
            'title' => 'Dashboard',
            'stats' => [
                'movies' => Movie::query()->count(),
                'rooms' => Room::query()->count(),
                'showtimes' => Showtime::query()->count(),
                'bookings' => Booking::query()->where('booking_status', '!=', 'expired')->count(),
                'users' => User::query()->count(),
                'paid_revenue' => $paidBookings->sum('total_price'),
                'paid_bookings' => $paidBookings->count(),
                'pending_bookings' => Booking::query()
                    ->where('booking_status', 'booked')
                    ->whereIn('payment_status', ['pending', 'pending_gateway'])
                    ->where('hold_expires_at', '>', now())
                    ->count(),
                'expired_bookings' => Booking::query()->where('booking_status', 'expired')->count(),
            ],
            'recentBookings' => $recentBookings,
            'moviesById' => $this->moviesByShowtime($recentBookings),
        ]);
    }

    public function movies(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $query = Movie::query()->orderByDesc('created_at');

        if ($search !== '') {
            $query->where('title', 'like', '%' . $search . '%');
        }

        return view('admin.movies.index', [
            'title' => 'Quản lý phim',
            'movies' => $query->paginate(12)->withQueryString(),
            'search' => $search,
        ]);
    }

    public function createMovie(): View
    {
        return view('admin.movies.form', [
            'title' => 'Thêm phim',
            'movie' => new Movie(),
            'action' => route('admin.movies.store'),
            'method' => 'POST',
        ]);
    }

    public function storeMovie(Request $request): RedirectResponse
    {
        Movie::create($this->movieData($request));

        return redirect()->route('admin.movies.index')->with('status', 'Đã thêm phim.');
    }

    public function editMovie(string $movieId): View
    {
        return view('admin.movies.form', [
            'title' => 'Sửa phim',
            'movie' => Movie::query()->findOrFail($movieId),
            'action' => route('admin.movies.update', ['movie' => $movieId]),
            'method' => 'PUT',
        ]);
    }

    public function updateMovie(Request $request, string $movieId): RedirectResponse
    {
        Movie::query()->findOrFail($movieId)->update($this->movieData($request, $movieId));

        return redirect()->route('admin.movies.index')->with('status', 'Đã cập nhật phim.');
    }

    public function deleteMovie(string $movieId): RedirectResponse
    {
        abort_if(Showtime::query()->where('movie_id', $movieId)->exists(), 422, 'Không thể xóa phim đang có suất chiếu.');

        Movie::query()->findOrFail($movieId)->delete();

        return back()->with('status', 'Đã xóa phim.');
    }

    public function rooms(): View
    {
        return view('admin.rooms.index', [
            'title' => 'Quản lý phòng chiếu',
            'rooms' => Room::query()->orderBy('name')->get(),
        ]);
    }

    public function storeRoom(Request $request): RedirectResponse
    {
        $data = $this->roomData($request);
        $room = Room::create($data);
        $this->syncSeats($room, (int) $data['total_seats']);

        return back()->with('status', 'Đã thêm phòng chiếu.');
    }

    public function updateRoom(Request $request, string $roomId): RedirectResponse
    {
        $data = $this->roomData($request);
        $room = Room::query()->findOrFail($roomId);
        $room->update($data);
        $this->syncSeats($room, (int) $data['total_seats']);

        return back()->with('status', 'Đã cập nhật phòng chiếu.');
    }

    public function deleteRoom(string $roomId): RedirectResponse
    {
        abort_if(Showtime::query()->where('room_id', $roomId)->exists(), 422, 'Không thể xóa phòng đang có suất chiếu.');

        $seatIds = Seat::query()->where('room_id', $roomId)->pluck('_id')->map(fn ($id) => (string) $id)->all();
        abort_if($seatIds !== [] && BookingSeat::query()->whereIn('seat_id', $seatIds)->exists(), 422, 'Không thể xóa phòng có ghế đã được đặt.');

        Seat::query()->where('room_id', $roomId)->delete();
        Room::query()->findOrFail($roomId)->delete();

        return back()->with('status', 'Đã xóa phòng chiếu.');
    }

    public function seats(string $roomId): View
    {
        $room = Room::query()->findOrFail($roomId);

        return view('admin.rooms.seats', [
            'title' => 'Quản lý ghế',
            'room' => $room,
            'seats' => Seat::query()->where('room_id', $roomId)->orderBy('seat_number')->get(),
        ]);
    }

    public function updateSeat(Request $request, string $seatId): RedirectResponse
    {
        $data = $request->validate([
            'seat_type' => ['required', Rule::in(['normal', 'vip', 'couple', 'blocked'])],
        ]);

        Seat::query()->findOrFail($seatId)->update($data);

        return back()->with('status', 'Đã cập nhật ghế.');
    }

    public function showtimes(): View
    {
        $movies = Movie::query()->orderBy('title')->get();
        $rooms = Room::query()->orderBy('name')->get();

        return view('admin.showtimes.index', [
            'title' => 'Quản lý suất chiếu',
            'showtimes' => Showtime::query()->orderByDesc('start_time')->paginate(15)->withQueryString(),
            'movies' => $movies,
            'rooms' => $rooms,
            'moviesById' => $movies->keyBy(fn ($movie) => (string) $movie->getKey()),
            'roomsById' => $rooms->keyBy(fn ($room) => (string) $room->getKey()),
        ]);
    }

    public function storeShowtime(Request $request): RedirectResponse
    {
        Showtime::create($this->showtimeData($request));

        return back()->with('status', 'Đã thêm suất chiếu.');
    }

    public function updateShowtime(Request $request, string $showtimeId): RedirectResponse
    {
        Showtime::query()->findOrFail($showtimeId)->update($this->showtimeData($request, $showtimeId));

        return back()->with('status', 'Đã cập nhật suất chiếu.');
    }

    public function deleteShowtime(string $showtimeId): RedirectResponse
    {
        abort_if(Booking::query()->where('showtime_id', $showtimeId)->exists(), 422, 'Không thể xóa suất chiếu đang có đặt vé.');

        Showtime::query()->findOrFail($showtimeId)->delete();

        return back()->with('status', 'Đã xóa suất chiếu.');
    }

    public function bookings(Request $request): View
    {
        $status = trim((string) $request->query('status', ''));
        $query = Booking::query()->orderByDesc('created_at');

        if ($status !== '') {
            $query->where('payment_status', $status);
        }

        $bookings = $query->paginate(15)->withQueryString();

        return view('admin.bookings.index', [
            'title' => 'Quản lý đặt vé',
            'bookings' => $bookings,
            'status' => $status,
            'moviesById' => $this->moviesByShowtime($bookings->getCollection()),
            'usersById' => User::query()->get()->keyBy(fn ($user) => (string) ($user->getKey() ?? $user->email)),
        ]);
    }

    public function bookingDetail(string $bookingId): View
    {
        $booking = Booking::query()->findOrFail($bookingId);
        $showtime = Showtime::query()->find($booking->showtime_id);
        $movie = $showtime ? Movie::query()->find($showtime->movie_id) : null;
        $room = $showtime ? Room::query()->find($showtime->room_id) : null;
        $bookingSeats = BookingSeat::query()->where('booking_id', $bookingId)->get();
        $seatIds = $bookingSeats->pluck('seat_id')->all();

        return view('admin.bookings.show', [
            'title' => 'Chi tiết đặt vé',
            'booking' => $booking,
            'showtime' => $showtime,
            'movie' => $movie,
            'room' => $room,
            'bookingSeats' => $bookingSeats,
            'seatsById' => $seatIds === [] ? collect() : Seat::query()->whereIn('_id', $seatIds)->get()->keyBy(fn ($seat) => (string) $seat->getKey()),
            'payments' => Payment::query()->where('booking_id', $bookingId)->orderByDesc('created_at')->get(),
        ]);
    }

    public function updateBooking(Request $request, string $bookingId): RedirectResponse
    {
        $data = $request->validate([
            'booking_status' => ['required', Rule::in(['booked', 'cancelled', 'checked_in', 'expired'])],
        ]);

        Booking::query()->findOrFail($bookingId)->update($data);

        return back()->with('status', 'Đã cập nhật đặt vé.');
    }

    public function users(Request $request): View
    {
        $search = trim((string) $request->query('q', ''));
        $query = User::query()->orderByDesc('created_at');

        if ($search !== '') {
            $query->where('email', 'like', '%' . $search . '%');
        }

        return view('admin.users.index', [
            'title' => 'Quản lý người dùng',
            'users' => $query->paginate(15)->withQueryString(),
            'search' => $search,
        ]);
    }

    public function updateUser(Request $request, string $userId): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'role' => ['required', Rule::in(['user', 'admin'])],
            'status' => ['required', Rule::in(['1', '0'])],
            'password' => ['nullable', 'string', 'min:8'],
        ]);

        $payload = [
            'name' => $data['name'],
            'phone' => $data['phone'] ?? null,
            'role' => $data['role'],
            'status' => $data['status'] === '1',
        ];

        if (!empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        User::query()->findOrFail($userId)->update($payload);

        return back()->with('status', 'Đã cập nhật người dùng.');
    }

    public function settings(): View
    {
        return view('admin.settings.index', [
            'title' => 'Cấu hình quản trị',
            'settings' => $this->adminSettings(),
        ]);
    }

    public function updateSettings(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:120'],
            'support_phone' => ['nullable', 'string', 'max:40'],
            'default_ticket_price' => ['required', 'integer', 'min:0', 'max:5000000'],
            'booking_hold_minutes' => ['required', 'integer', 'min:1', 'max:60'],
        ]);

        AdminSetting::query()->updateOrCreate(
            ['key' => 'admin_settings'],
            ['type' => 'admin', 'value' => $data]
        );

        return back()->with('status', 'Đã lưu cấu hình.');
    }

    private function movieData(Request $request, ?string $movieId = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'duration' => ['nullable', 'integer', 'min:1', 'max:600'],
            'genre' => ['nullable', 'string', 'max:255'],
            'language' => ['nullable', 'string', 'max:100'],
            'release_date' => ['nullable', 'date'],
            'poster' => ['nullable', 'string', 'max:1000'],
            'trailer' => ['nullable', 'string', 'max:1000'],
            'age_label' => ['nullable', 'string', 'max:20'],
            'section' => ['required', Rule::in(['now-showing', 'upcoming', 'special'])],
            'is_active' => ['required', Rule::in(['1', '0'])],
        ]);

        $baseSlug = Str::slug((string) $data['title']);
        $slug = $baseSlug;
        $suffix = 2;

        while (Movie::query()
            ->where('slug', $slug)
            ->when($movieId !== null, fn ($query) => $query->where('_id', '!=', $movieId))
            ->exists()) {
            $slug = $baseSlug . '-' . $suffix++;
        }

        $data['slug'] = $slug;
        $data['duration'] = isset($data['duration']) ? (int) $data['duration'] : null;
        $data['is_active'] = $data['is_active'] === '1';

        return $data;
    }

    private function roomData(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'total_seats' => ['required', 'integer', 'min:1', 'max:300'],
        ]);
    }

    private function showtimeData(Request $request, ?string $ignoreShowtimeId = null): array
    {
        $data = $request->validate([
            'movie_id' => ['required', 'string'],
            'room_id' => ['required', 'string'],
            'start_time' => ['required', 'date'],
            'end_time' => ['required', 'date', 'after:start_time'],
            'price' => ['required', 'integer', 'min:0', 'max:5000000'],
            'format' => ['nullable', 'string', 'max:60'],
        ]);

        abort_unless(Movie::query()->where('_id', $data['movie_id'])->exists(), 422);
        abort_unless(Room::query()->where('_id', $data['room_id'])->exists(), 422);

        $data['start_time'] = Carbon::parse($data['start_time']);
        $data['end_time'] = Carbon::parse($data['end_time']);
        $data['price'] = (int) $data['price'];
        $data['format'] = $data['format'] ?: '2D Phụ đề';
        $data['is_active'] = true;

        $overlaps = Showtime::query()
            ->where('room_id', $data['room_id'])
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time'])
            ->get()
            ->filter(fn (Showtime $showtime) => $ignoreShowtimeId === null || (string) $showtime->getKey() !== $ignoreShowtimeId)
            ->isNotEmpty();

        abort_if($overlaps, 422, 'Phòng này đã có suất chiếu trùng thời gian.');

        return $data;
    }

    private function syncSeats(Room $room, int $totalSeats): void
    {
        $roomId = (string) $room->getKey();
        $existing = Seat::query()->where('room_id', $roomId)->pluck('seat_number')->all();

        for ($i = 1; $i <= $totalSeats; $i++) {
            $seatNumber = 'A' . $i;
            if (!in_array($seatNumber, $existing, true)) {
                Seat::create([
                    'room_id' => $roomId,
                    'seat_number' => $seatNumber,
                    'seat_type' => 'normal',
                ]);
            }
        }
    }

    private function moviesByShowtime($bookings): \Illuminate\Support\Collection
    {
        $showtimeIds = collect($bookings)->pluck('showtime_id')->filter()->unique()->all();
        $showtimes = $showtimeIds === [] ? collect() : Showtime::query()->whereIn('_id', $showtimeIds)->get();
        $movieIds = $showtimes->pluck('movie_id')->filter()->unique()->all();

        if ($movieIds === []) {
            return collect();
        }

        $moviesById = Movie::query()->whereIn('_id', $movieIds)->get()->keyBy(fn ($movie) => (string) $movie->getKey());

        return $showtimes->mapWithKeys(fn (Showtime $showtime) => [
            (string) $showtime->getKey() => $moviesById[(string) $showtime->movie_id] ?? null,
        ]);
    }

    private function adminSettings(): array
    {
        $defaults = [
            'site_name' => 'Beta Cinemas',
            'support_phone' => '1900 636807',
            'default_ticket_price' => 75000,
            'booking_hold_minutes' => 10,
        ];

        $stored = AdminSetting::query()->where('key', 'admin_settings')->first()?->value;

        return array_merge($defaults, is_array($stored) ? $stored : []);
    }

    private function releaseExpiredHolds(): void
    {
        Booking::query()
            ->where('booking_status', 'booked')
            ->whereIn('payment_status', ['pending', 'pending_gateway'])
            ->whereNotNull('hold_expires_at')
            ->where('hold_expires_at', '<=', now())
            ->update(['booking_status' => 'expired']);
    }
}

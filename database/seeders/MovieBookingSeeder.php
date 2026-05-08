<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Payment;
use App\Models\Room;
use App\Models\Seat;
use App\Models\Showtime;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MovieBookingSeeder extends Seeder
{
    public function run(): void
    {
        $siteData = $this->siteData();
        $cinema = Cinema::query()->firstOrCreate(
            ['name' => 'Beta Thai Nguyen'],
            ['address' => 'Beta Thai Nguyen', 'city' => 'Thai Nguyen']
        );
        $room = Room::query()->firstOrCreate(
            ['cinema_id' => (string) $cinema->getKey(), 'name' => 'Phong 1'],
            ['total_seats' => 82]
        );

        $this->seedSeats($room);

        foreach (array_slice($siteData['movies'] ?? [], 0, 20) as $movieData) {
            $movie = Movie::query()->updateOrCreate(
                ['slug' => (string) ($movieData['id'] ?? Str::slug((string) ($movieData['title'] ?? Str::random(8))))],
                [
                    'title' => (string) ($movieData['title'] ?? 'Untitled'),
                    'section' => (string) ($movieData['section'] ?? 'now-showing'),
                    'genre' => $movieData['genre'] ?? null,
                    'duration' => (int) ($movieData['duration'] ?? 120),
                    'age_label' => $movieData['label'] ?? null,
                    'tag' => $movieData['tag'] ?? null,
                    'poster' => $movieData['poster'] ?? null,
                    'description' => $movieData['description'] ?? null,
                    'release_date' => $this->parseReleaseDate($movieData['releaseDate'] ?? null),
                    'language' => $movieData['language'] ?? null,
                    'trailer' => $movieData['trailer'] ?? null,
                    'details' => $movieData['details'] ?? null,
                    'is_active' => true,
                ]
            );

            $this->seedShowtimes($movie, $room, $movieData, $siteData);
        }

        $this->seedUsersAndBookings();
    }

    private function siteData(): array
    {
        $path = resource_path('data/web-home.json');
        $decoded = is_readable($path) ? json_decode((string) file_get_contents($path), true) : null;

        return is_array($decoded) ? $decoded : [];
    }

    private function seedSeats(Room $room): void
    {
        $rows = [
            'H' => range(11, 1),
            'G' => range(11, 1),
            'F' => range(9, 1),
            'E' => range(9, 1),
            'D' => range(10, 1),
            'C' => range(10, 1),
            'B' => range(10, 1),
            'A' => range(10, 1),
        ];

        foreach ($rows as $row => $numbers) {
            foreach ($numbers as $number) {
                Seat::query()->firstOrCreate(
                    ['room_id' => (string) $room->getKey(), 'seat_number' => $row . $number],
                    ['seat_type' => in_array($row, ['A', 'B'], true) ? 'vip' : 'normal']
                );
            }
        }

        $room->forceFill(['total_seats' => Seat::query()->where('room_id', (string) $room->getKey())->count()])->save();
    }

    private function seedShowtimes(Movie $movie, Room $room, array $movieData, array $siteData): void
    {
        $groups = $movieData['showtimeGroups'] ?? $siteData['defaultShowtimeGroups'] ?? [];
        $dates = $movieData['scheduleDates'] ?? $siteData['defaultScheduleDates'] ?? [];

        foreach (array_slice($dates, 0, 4) as $date) {
            $showDate = $this->parseScheduleDate(($date['label'] ?? '') . ($date['suffix'] ?? ''));
            if ($showDate === null) {
                continue;
            }

            foreach ($groups as $group) {
                foreach (array_slice($group['slots'] ?? [], 0, 4) as $slot) {
                    $time = $slot['time'] ?? null;
                    if (! is_string($time) || ! preg_match('/^\d{1,2}:\d{2}$/', $time)) {
                        continue;
                    }

                    $start = Carbon::createFromFormat('Y-m-d H:i', $showDate . ' ' . $time);
                    Showtime::query()->firstOrCreate(
                        [
                            'movie_id' => (string) $movie->getKey(),
                            'room_id' => (string) $room->getKey(),
                            'start_time' => $start,
                            'format' => (string) ($group['format'] ?? '2D Phu de'),
                        ],
                        [
                            'end_time' => (clone $start)->addMinutes((int) ($movie->duration ?? 120)),
                            'price' => 75000,
                            'is_active' => true,
                        ]
                    );
                }
            }
        }
    }

    private function seedUsersAndBookings(): void
    {
        $users = collect([
            ['name' => 'Nguyễn Minh Anh', 'email' => 'minhanh@example.com', 'phone' => '0901000001', 'role' => 'user', 'status' => true],
            ['name' => 'Trần Quốc Bảo', 'email' => 'quocbao@example.com', 'phone' => '0901000002', 'role' => 'user', 'status' => true],
            ['name' => 'Lê Hà Phương', 'email' => 'haphuong@example.com', 'phone' => '0901000003', 'role' => 'user', 'status' => true],
            ['name' => 'Phạm Gia Hân', 'email' => 'giahan@example.com', 'phone' => '0901000004', 'role' => 'user', 'status' => false],
            ['name' => 'Quản trị Beta', 'email' => 'admin@example.com', 'phone' => '0901000000', 'role' => 'admin', 'status' => true],
        ])->map(function (array $data) {
            return User::query()->updateOrCreate(
                ['email' => $data['email']],
                array_merge($data, ['password' => Hash::make('password')])
            );
        })->values();

        $showtimes = Showtime::query()->orderBy('start_time')->limit(8)->get();
        $seats = Seat::query()->orderBy('seat_number')->limit(32)->get();

        if ($showtimes->isEmpty() || $seats->isEmpty()) {
            return;
        }

        $paymentStatuses = ['paid', 'pending', 'paid', 'pending_gateway', 'failed'];
        $bookingStatuses = ['booked', 'booked', 'checked_in', 'booked', 'cancelled'];

        foreach ($users->take(5)->values() as $index => $user) {
            $showtime = $showtimes[$index % $showtimes->count()];
            $bookingSeats = $seats->slice($index * 2, 2)->values();

            if ($bookingSeats->count() < 2) {
                $bookingSeats = $seats->take(2)->values();
            }

            $paymentStatus = $paymentStatuses[$index] ?? 'pending';
            $bookingStatus = $bookingStatuses[$index] ?? 'booked';
            $seatPrice = (int) ($showtime->price ?? 75000);
            $bookingCode = 'BCDEMO' . str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT);

            $booking = Booking::query()->updateOrCreate(
                ['qr_code' => $bookingCode],
                [
                    'user_id' => (string) $user->getKey(),
                    'showtime_id' => (string) $showtime->getKey(),
                    'total_price' => $bookingSeats->count() * $seatPrice,
                    'payment_status' => $paymentStatus,
                    'booking_status' => $bookingStatus,
                    'customer_name' => $user->name,
                    'customer_email' => $user->email,
                    'customer_phone' => $user->phone,
                ]
            );

            foreach ($bookingSeats as $seat) {
                BookingSeat::query()->updateOrCreate(
                    [
                        'booking_id' => (string) $booking->getKey(),
                        'seat_id' => (string) $seat->getKey(),
                    ],
                    ['price' => $seatPrice]
                );
            }

            if (in_array($paymentStatus, ['paid', 'failed'], true)) {
                Payment::query()->updateOrCreate(
                    ['transaction_code' => 'PAYDEMO' . str_pad((string) ($index + 1), 3, '0', STR_PAD_LEFT)],
                    [
                        'booking_id' => (string) $booking->getKey(),
                        'method' => $index % 2 === 0 ? 'Momo' : 'VNPay',
                        'amount' => (int) $booking->total_price,
                        'payment_date' => now()->subDays(max(0, 4 - $index)),
                        'status' => $paymentStatus,
                    ]
                );
            }
        }
    }

    private function parseReleaseDate(?string $value): ?string
    {
        if ($value === null || trim($value) === '') {
            return null;
        }

        try {
            return Carbon::createFromFormat('d/m/Y', trim($value))->toDateString();
        } catch (\Throwable) {
            return null;
        }
    }

    private function parseScheduleDate(string $value): ?string
    {
        if (! preg_match('/\d{1,2}\/\d{1,2}/', $value, $match)) {
            return null;
        }

        try {
            return Carbon::createFromFormat('d/m/Y', $match[0] . '/' . now()->year)->toDateString();
        } catch (\Throwable) {
            return null;
        }
    }
}

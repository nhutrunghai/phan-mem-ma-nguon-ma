<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingSeat;
use App\Models\Movie;
use App\Models\Showtime;
use Illuminate\Support\Carbon;

class MovieCatalog
{
    public function loadSiteData(): array
    {
        $dataPath = resource_path('data/web-home.json');

        if (! is_readable($dataPath)) {
            return [];
        }

        $decoded = json_decode((string) file_get_contents($dataPath), true);

        return is_array($decoded) ? $decoded : [];
    }

    public function mergedMovies(?array $siteData = null, array $trackerMovies = []): array
    {
        $siteData ??= $this->loadSiteData();
        $staticMovies = $this->staticMovies($siteData, $trackerMovies);
        $dbMovies = $this->databaseMovies();

        if ($dbMovies === []) {
            return $staticMovies;
        }

        return collect($dbMovies)
            ->sortBy(fn (array $movie) => (empty($movie['scheduleDates']) ? '1' : '0') . '|' . (string) ($movie['title'] ?? ''))
            ->values()
            ->all();
    }

    public function findMovie(string $id, ?array $siteData = null, array $trackerMovies = []): ?array
    {
        $movie = collect($this->mergedMovies($siteData, $trackerMovies))->firstWhere('id', $id);

        return is_array($movie) ? $movie : null;
    }

    private function staticMovies(array $siteData, array $trackerMovies): array
    {
        $tracker = collect($trackerMovies)->map(function (array $movie) {
            $movie['buyUrl'] = route('movies.show', ['id' => $movie['id']]);

            return $movie;
        });

        $movies = collect($siteData['movies'] ?? [])->map(function (array $movie) {
            $buyUrl = (string) ($movie['buyUrl'] ?? '');

            if (($movie['id'] ?? null) !== null) {
                $movie['buyUrl'] = route('movies.show', ['id' => $movie['id']]);
            } elseif (str_ends_with($buyUrl, '.php') || str_contains($buyUrl, '.php?')) {
                $movie['buyUrl'] = '#';
            }

            return $movie;
        })->reject(fn (array $movie) => ($movie['section'] ?? null) === 'now-showing')->values();

        return $tracker->concat($movies)->values()->all();
    }

    private function databaseMovies(): array
    {
        try {
            $movies = Movie::query()
                ->with(['showtimes' => fn ($query) => $query
                    ->with('room')
                    ->where('is_active', true)
                    ->where('start_time', '>=', now())
                    ->orderBy('start_time')])
                ->where('is_active', true)
                ->orderBy('release_date')
                ->get();
        } catch (\Throwable) {
            return [];
        }

        return $movies
            ->sortBy(fn (Movie $movie) => ($movie->section === 'now-showing' ? '0' : '1') . '|' . (string) $movie->release_date)
            ->map(fn (Movie $movie) => $this->mapMovie($movie))
            ->values()
            ->all();
    }

    private function mapMovie(Movie $movie): array
    {
        $showtimes = $movie->showtimes;
        $scheduleDates = $showtimes
            ->groupBy(fn (Showtime $showtime) => $showtime->start_time->format('Y-m-d'))
            ->keys()
            ->values()
            ->map(function (string $date, int $index) {
                $dateValue = Carbon::parse($date);

                return [
                    'label' => $dateValue->format('d/m'),
                    'suffix' => '',
                    'active' => $index === 0,
                ];
            })->all();

        $scheduleByDate = $showtimes
            ->groupBy(fn (Showtime $showtime) => $showtime->start_time->format('Y-m-d'))
            ->values()
            ->map(function ($items, int $index) {
                $date = $items->first()->start_time;

                return [
                    'label' => $date->format('d/m'),
                    'suffix' => '',
                    'active' => $index === 0,
                    'groups' => $this->showtimeGroups($items),
                ];
            })->all();

        return [
            'id' => $movie->slug,
            'section' => $movie->section,
            'title' => $movie->title,
            'genre' => $movie->genre,
            'duration' => $movie->duration,
            'label' => $movie->age_label,
            'tag' => $movie->tag,
            'poster' => $movie->poster,
            'buyUrl' => route('movies.show', ['id' => $movie->slug]),
            'description' => $movie->description,
            'releaseDate' => $movie->release_date?->format('d/m/Y'),
            'language' => $movie->language,
            'trailer' => $movie->trailer,
            'details' => $movie->details ?: $this->defaultDetails($movie),
            'scheduleDates' => $scheduleDates,
            'showtimeGroups' => $scheduleByDate[0]['groups'] ?? [],
            'scheduleByDate' => $scheduleByDate,
            'showtimes' => $showtimes->map(fn (Showtime $showtime) => [
                'id' => (string) $showtime->getKey(),
                'date' => $showtime->start_time->format('d/m'),
                'time' => $showtime->start_time->format('H:i'),
                'format' => $showtime->format,
                'seats' => $this->availableSeatLabel($showtime),
                'room' => $showtime->room?->name,
            ])->all(),
        ];
    }

    private function showtimeGroups($showtimes): array
    {
        return $showtimes
            ->groupBy('format')
            ->map(fn ($items, string $format) => [
                'format' => $format,
                'slots' => $items->values()->map(fn (Showtime $showtime, int $index) => [
                    'id' => (string) $showtime->getKey(),
                    'time' => $showtime->start_time->format('H:i'),
                    'seats' => $this->availableSeatLabel($showtime),
                    'room' => $showtime->room?->name,
                    'active' => $index === 0,
                ])->all(),
            ])->values()->all();
    }

    private function availableSeatLabel(Showtime $showtime): string
    {
        $this->releaseExpiredHolds();

        $capacity = (int) ($showtime->room?->total_seats ?: $showtime->room?->seats()->count() ?: 0);
        $bookingIds = $this->unavailableBookingIds($showtime);

        $unavailable = $bookingIds === []
            ? 0
            : BookingSeat::query()->whereIn('booking_id', $bookingIds)->count();

        return max(0, $capacity - $unavailable) . ' ghế trống';
    }

    private function unavailableBookingIds(Showtime $showtime): array
    {
        $this->normalizeMissingHoldExpiry($showtime);

        $paidBookingIds = Booking::query()
            ->where('showtime_id', (string) $showtime->getKey())
            ->where('booking_status', 'booked')
            ->where('payment_status', 'paid')
            ->get()
            ->map(fn (Booking $booking) => (string) $booking->getKey())
            ->all();

        $activeHoldBookingIds = Booking::query()
            ->where('showtime_id', (string) $showtime->getKey())
            ->where('booking_status', 'booked')
            ->whereIn('payment_status', ['pending', 'pending_gateway'])
            ->where('hold_expires_at', '>', now())
            ->get()
            ->map(fn (Booking $booking) => (string) $booking->getKey())
            ->all();

        return collect($paidBookingIds)
            ->merge($activeHoldBookingIds)
            ->unique()
            ->values()
            ->all();
    }

    private function normalizeMissingHoldExpiry(Showtime $showtime): void
    {
        Booking::query()
            ->where('showtime_id', (string) $showtime->getKey())
            ->where('booking_status', 'booked')
            ->whereIn('payment_status', ['pending', 'pending_gateway'])
            ->whereNull('hold_expires_at')
            ->update(['hold_expires_at' => now()->addMinutes(10)]);
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

    private function defaultDetails(Movie $movie): array
    {
        return [
            ['label' => 'Thể loại', 'value' => $movie->genre ?? 'Đang cập nhật'],
            ['label' => 'Thời lượng', 'value' => $movie->duration ? ($movie->duration . ' phút') : 'Đang cập nhật'],
            ['label' => 'Ngôn ngữ', 'value' => $movie->language ?? 'Tiếng Việt'],
            ['label' => 'Ngày khởi chiếu', 'value' => $movie->release_date?->format('d/m/Y') ?? 'Đang cập nhật'],
        ];
    }
}

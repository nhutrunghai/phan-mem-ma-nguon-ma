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

        $byId = collect($staticMovies)->keyBy(fn (array $movie) => (string) ($movie['id'] ?? ''));

        foreach ($dbMovies as $movie) {
            $id = (string) ($movie['id'] ?? '');
            $byId[$id] = array_replace($byId->get($id, []), $movie);
        }

        return $byId->values()->all();
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
                    ->where('is_active', true)
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
                'date' => $showtime->start_time->format('d/m'),
                'time' => $showtime->start_time->format('H:i'),
                'format' => $showtime->format,
                'seats' => $this->availableSeatLabel($showtime),
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
                    'time' => $showtime->start_time->format('H:i'),
                    'seats' => $this->availableSeatLabel($showtime),
                    'active' => $index === 0,
                ])->all(),
            ])->values()->all();
    }

    private function availableSeatLabel(Showtime $showtime): string
    {
        $capacity = (int) ($showtime->room?->total_seats ?: $showtime->room?->seats()->count() ?: 0);
        $bookingIds = Booking::query()
            ->where('showtime_id', (string) $showtime->getKey())
            ->where('booking_status', 'booked')
            ->pluck('_id')
            ->map(fn ($id) => (string) $id)
            ->all();

        $sold = $bookingIds === []
            ? 0
            : BookingSeat::query()->whereIn('booking_id', $bookingIds)->count();

        return max(0, $capacity - $sold) . ' ghế trống';
    }

    private function defaultDetails(Movie $movie): array
    {
        return [
            ['label' => 'The loai', 'value' => $movie->genre ?? 'Dang cap nhat'],
            ['label' => 'Thoi luong', 'value' => $movie->duration ? ($movie->duration . ' phut') : 'Dang cap nhat'],
            ['label' => 'Ngon ngu', 'value' => $movie->language ?? 'Tieng Viet'],
            ['label' => 'Ngay khoi chieu', 'value' => $movie->release_date?->format('d/m/Y') ?? 'Dang cap nhat'],
        ];
    }
}

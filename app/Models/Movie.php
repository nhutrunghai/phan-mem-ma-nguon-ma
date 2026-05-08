<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use MongoDB\Laravel\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'section',
        'genre',
        'duration',
        'age_label',
        'tag',
        'poster',
        'description',
        'release_date',
        'language',
        'trailer',
        'details',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'details' => 'array',
            'release_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function showtimes(): HasMany
    {
        return $this->hasMany(Showtime::class);
    }
}

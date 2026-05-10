<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use MongoDB\Laravel\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name', 'total_seats'];

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }
}

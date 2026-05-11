<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MongoDB\Laravel\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'showtime_id',
        'total_price',
        'payment_status',
        'booking_status',
        'customer_name',
        'customer_email',
        'customer_phone',
        'qr_code',
        'hold_expires_at',
    ];

    protected $casts = [
        'hold_expires_at' => 'datetime',
    ];

    public function showtime(): BelongsTo
    {
        return $this->belongsTo(Showtime::class);
    }

    public function seats(): HasMany
    {
        return $this->hasMany(BookingSeat::class);
    }
}

<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Payment extends Model
{
    protected $connection = 'mongodb';

    protected $table = 'payments';

    protected $fillable = [
        'booking_id',
        'method',
        'amount',
        'transaction_code',
        'payment_date',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'integer',
            'payment_date' => 'datetime',
        ];
    }
}

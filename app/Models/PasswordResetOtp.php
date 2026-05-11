<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class PasswordResetOtp extends Model
{
    protected $connection = 'mongodb';

    protected $table = 'password_reset_otps';

    protected $fillable = [
        'email',
        'code_hash',
        'attempts',
        'expires_at',
        'used_at',
    ];

    protected function casts(): array
    {
        return [
            'attempts' => 'integer',
            'expires_at' => 'datetime',
            'used_at' => 'datetime',
        ];
    }
}

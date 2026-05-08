<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class AdminSetting extends Model
{
    protected $fillable = ['key', 'value', 'type'];

    protected function casts(): array
    {
        return [
            'value' => 'array',
        ];
    }
}

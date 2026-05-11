<?php

return [
    'sepay' => [
        'enabled' => env('SEPAY_ENABLED', true),
        'api_token' => env('SEPAY_API_TOKEN'),
        'bank_account_id' => env('SEPAY_BANK_ACCOUNT_ID'),
        'bank_short_name' => env('SEPAY_BANK_SHORT_NAME', 'MBBank'),
        'bank_account_number' => env('SEPAY_BANK_ACCOUNT_NUMBER'),
        'bank_account_holder_name' => env('SEPAY_BANK_ACCOUNT_HOLDER_NAME'),
        'webhook_secret' => env('SEPAY_WEBHOOK_SECRET'),
    ],
];

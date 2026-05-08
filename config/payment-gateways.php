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
    'vnpay' => [
        'enabled' => env('VNPAY_ENABLED', false),
        'tmn_code' => env('VNPAY_TMN_CODE'),
        'hash_secret' => env('VNPAY_HASH_SECRET'),
        'url' => env('VNPAY_URL', 'https://sandbox.vnpayment.vn/paymentv2/vpcpay.html'),
        'return_url' => env('VNPAY_RETURN_URL', env('APP_URL') . '/thanh-toan/return/vnpay'),
        'ipn_url' => env('VNPAY_IPN_URL', env('APP_URL') . '/thanh-toan/ipn/vnpay'),
        'version' => env('VNPAY_VERSION', '2.1.0'),
        'currency' => env('VNPAY_CURRENCY', 'VND'),
        'locale' => env('VNPAY_LOCALE', 'vn'),
    ],
];

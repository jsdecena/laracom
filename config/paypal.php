<?php

return [
    'name' => 'paypal',
    'description' => 'PayPal - Safe, Secured and Easy to pay online!',
    'account_id' => env('PP_ACCOUNT_ID', 'xxxx'),
    'client_id' => env('PP_CLIENT_ID', 'xxxx'),
    'client_secret' => env('PP_CLIENT_SECRET', 'xxxx'),
    'api_url' => env('PP_API_URL', 'https://api.sandbox.paypal.com'),
    'redirect_url' => env('PP_REDIRECT_URL', 'xxxx'),
    'cancel_url' => env('PP_CANCEL_URL', 'xxxx'),
    'failed_url' => env('PP_FAILED_URL', 'xxxx'),
    'mode' => env('PP_MODE', 'xxxx')
];
<?php
    return [
        'name' => 'stripe',
        'description' => 'The new standard in online payments',
        'key' => env('STRIPE_KEY', 'xxx'),
        'secret' => env('STRIPE_SECRET', 'xxx'),
        'redirect_url' => env('STRIPE_REDIRECT_URL', 'xxxx'),
        'cancel_url' => env('STRIPE_CANCEL_URL', 'xxxx'),
        'failed_url' => env('STRIPE_FAILED_URL', 'xxxx'),
    ];
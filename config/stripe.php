<?php
    return [
        'name' => 'stripe',
        'description' => 'The new standard in online payments',
        'key' => env('STRIPE_KEY', 'xxx'),
        'secret' => env('STRIPE_SECRET', 'xxx')
    ];
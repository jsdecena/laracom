<?php

return [
    'shipping_token' => env('SHIPPING_API_TOKEN'),
    'name' => env('SHOP_NAME', 'Laracom'),
    'country' => env('SHOP_COUNTRY_ISO', 'US'),
    'country_id' => env('SHOP_COUNTRY_ID', 226),
    'weight' => env('SHOP_WEIGHT', 'lbs'),
    'email' => env('SHOP_EMAIL', 'john@doe.com'),
    'phone' => env('SHOP_PHONE', '1 855 791 4041'),
    'warehouse' => [
        'address_1' => '1600 Amphitheatre Parkway',
        'address_2' => '',
        'state' => 'CA',
        'city' => 'Mountain View',
        'country' => 'US',
        'zip' => '94043',
    ]
];
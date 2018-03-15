<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Shop\Orders\Order;

$factory->define(Order::class, function (Faker\Generator $faker) {

    return [
        'reference' => $faker->uuid,
        'courier_id' => 1,
        'customer_id' => 1,
        'address_id' => 1,
        'order_status_id' => 1,
        'payment' => 'paypal',
        'discounts' => $faker->randomFloat(2, 10, 999),
        'total_products' => $faker->randomFloat(2, 10, 5555),
        'tax' => $faker->randomFloat(2, 10, 9999),
        'total' => $faker->randomFloat(2, 10, 9999),
        'total_paid' => $faker->randomFloat(2, 10, 9999),
        'invoice' => null,
    ];
});

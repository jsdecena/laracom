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

use App\Shop\Addresses\Address;
use App\Shop\Cities\City;
use App\Shop\Couriers\Courier;
use App\Shop\Customers\Customer;
use App\Shop\Orders\Order;
use App\Shop\OrderStatuses\OrderStatus;

$factory->define(Order::class, function (Faker\Generator $faker) {

    $courier = factory(Courier::class)->create();
    $customer = factory(Customer::class)->create();

    $city = factory(City::class)->create();
    $address = factory(Address::class)->create([
        'country_id' => 1,
        'city' => $city->name,
        'customer_id' => $customer->id
    ]);

    $os = factory(OrderStatus::class)->create();

    return [
        'reference' => $faker->uuid,
        'courier_id' => $courier->id,
        'customer_id' => $customer->id,
        'address_id' => $address->id,
        'order_status_id' => $os->id,
        'payment' => 'paypal',
        'discounts' => $faker->randomFloat(2, 10, 999),
        'total_products' => $faker->randomFloat(2, 10, 5555),
        'tax' => $faker->randomFloat(2, 10, 9999),
        'total' => $faker->randomFloat(2, 10, 9999),
        'total_paid' => $faker->randomFloat(2, 10, 9999),
        'invoice' => null,
    ];
});

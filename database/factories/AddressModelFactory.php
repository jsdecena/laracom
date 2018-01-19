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
use App\Shop\Customers\Customer;

$factory->define(Address::class, function (Faker\Generator $faker) {

    $customer = factory(Customer::class)->create();

    return [
        'alias' => $faker->word,
        'address_1' => $faker->streetName,
        'address_2' => $faker->streetAddress,
        'zip' => $faker->postcode,
        'city_id' => 1,
        'province_id' => 1,
        'country_id' => 1,
        'customer_id' => $customer->id,
        'status' => 1
    ];
});

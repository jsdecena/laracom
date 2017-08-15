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
use App\Addresses\Address;

$factory->define(Address::class, function (Faker\Generator $faker) {

    return [
        'alias' => $faker->word,
        'address_1' => $faker->sentence,
        'address_2' => $faker->sentence,
        'zip' => 1101,
        'city_id' => 1,
        'province_id' => 1,
        'country_id' => 169,
        'customer_id' => 1,
        'status' => 1
    ];
});

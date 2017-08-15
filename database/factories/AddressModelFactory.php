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
use App\Customers\Customer;
use App\Provinces\Province;
use App\Cities\City;
use App\Countries\Country;

$factory->define(Address::class, function (Faker\Generator $faker) {

    $country = factory(Country::class)->create();
    $province = factory(Province::class)->create();
    $city = factory(City::class)->create();
    $customer = factory(Customer::class)->create();

    return [
        'alias' => $faker->word,
        'address_1' => $faker->streetName,
        'address_2' => $faker->streetAddress,
        'zip' => $faker->postcode,
        'city_id' => $city->id,
        'province_id' => $province->id,
        'country_id' => $country->id,
        'customer_id' => $customer->id,
        'status' => 1
    ];
});

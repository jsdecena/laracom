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
use App\Provinces\Province;
use App\Countries\Country;

$factory->define(Province::class, function (Faker\Generator $faker) {

    $country = factory(Country::class)->create();

    return [
        'name' => $faker->country,
        'country_id' => $country->id
    ];
});

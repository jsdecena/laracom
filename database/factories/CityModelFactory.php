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
use App\Cities\City;

$factory->define(City::class, function (Faker\Generator $faker) {

    $province = factory(Province::class)->create();

    return [
        'name' => $faker->country,
        'province_id' => $province->id
    ];
});

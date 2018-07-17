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
use App\Shop\Provinces\Province;
use App\Shop\Cities\City;

$factory->define(City::class, function (Faker\Generator $faker) {

    $province = factory(Province::class)->create();

    return [
        'name' => $faker->city,
        'province_id' => $province->id
    ];
});

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
use App\Couriers\Courier;

$factory->define(Courier::class, function (Faker\Generator $faker) {

    return [
        'name' => $faker->company,
        'description' => $faker->paragraph,
        'url' => $faker->sentence,
        'is_free' => 0,
        'status' => 1
    ];
});

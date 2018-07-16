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

use App\Shop\Countries\Country;
use App\Shop\States\State;

$factory->define(State::class, function (Faker\Generator $faker) {
    $country = factory(Country::class)->create();

    return [
        'state' => $faker->city,
        'state_code' => $faker->word,
        'country_id' => $country->id
    ];
});

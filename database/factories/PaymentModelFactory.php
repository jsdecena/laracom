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
use App\Shop\PaymentMethods\PaymentMethod;

$factory->define(PaymentMethod::class, function (Faker\Generator $faker) {
    $name = $faker->word;
    return [
        'name' => $name,
        'slug' => str_slug($name),
        'description' => $faker->sentence,
        'account_id' => $faker->uuid,
        'client_id' => $faker->uuid,
        'client_secret' => $faker->uuid,
        'api_url' => $faker->url,
        'redirect_url' => $faker->url,
        'cancel_url' => $faker->url,
        'failed_url' => $faker->url,
        'status' => 1
    ];
});

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
use App\PaymentMethods\PaymentMethod;

$factory->define(PaymentMethod::class, function (Faker\Generator $faker) {

    $name = 'Paypal';

    return [
        'name' => $name,
        'slug' => str_slug($name),
        'description' => 'Paypal payment',
        'status' => 1
    ];
});

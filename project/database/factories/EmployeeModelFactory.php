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
use App\Shop\Employees\Employee;
use Illuminate\Support\Str;

$factory->define(Employee::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => Str::random(10),
        'status' => 1
    ];
});

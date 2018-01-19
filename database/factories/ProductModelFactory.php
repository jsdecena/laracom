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
use App\Shop\Products\Product;

$factory->define(Product::class, function (Faker\Generator $faker) {
    $product = $faker->unique()->sentence;

    return [
        'sku' => $this->faker->numberBetween(1111111, 999999),
        'name' => $product,
        'slug' => str_slug($product),
        'description' => $this->faker->paragraph,
        'cover' => null,
        'quantity' => 10,
        'price' => 5.00,
        'status' => 1
    ];
});

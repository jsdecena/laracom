<?php

use App\Categories\Category;
use App\Products\Product;
use Illuminate\Database\Seeder;

class CategoryProductsTableSeeder extends Seeder
{
    public function run()
    {
        factory(Category::class, 5)->create()->each(function ($category) {
            factory(Product::class, 5)->make()->each(function($product) use ($category) {
                $category->products()->save($product);
            });
        });
    }
}
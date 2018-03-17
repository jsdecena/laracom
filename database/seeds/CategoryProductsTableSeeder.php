<?php

use App\Shop\Categories\Category;
use App\Shop\Products\Product;
use Illuminate\Database\Seeder;

class CategoryProductsTableSeeder extends Seeder
{
    public function run()
    {
        factory(Category::class, 3)->create()->each(function (Category $category) {
            factory(Product::class, 5)->make()->each(function(Product $product) use ($category) {
                $category->products()->save($product);
            });
        });

        factory(Category::class)->create([
            'name' => 'New Arrivals',
            'slug' => 'new-arrivals',
            'status' => 1
        ])->each(function (Category $category) {
            factory(Product::class, 3)->make()->each(function(Product $product) use ($category) {
                $category->products()->save($product);
            });
        });

        factory(Category::class)->create([
            'name' => 'Featured',
            'slug' => 'featured',
            'status' => 1
        ])->each(function (Category $category) {
            factory(Product::class, 3)->make()->each(function(Product $product) use ($category) {
                $category->products()->save($product);
            });
        });
    }
}
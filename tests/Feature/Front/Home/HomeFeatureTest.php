<?php

namespace Tests\Feature\Front\Home;

use App\Shop\Categories\Category;
use App\Shop\Products\Product;
use Tests\TestCase;

class HomeFeatureTest extends TestCase
{
    /** @test */
    public function it_should_show_the_homepage()
    {
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

        $this
            ->get(route('home'))
            ->assertSee('Login')
            ->assertSee('Register')
            ->assertSee('New Arrivals')
            ->assertSee('Featured Products')
            ->assertStatus(200);
    }
}

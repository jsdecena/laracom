<?php

namespace Tests\Feature\Front\Home;

use App\Shop\Categories\Category;
use App\Shop\Categories\Repositories\CategoryRepository;
use App\Shop\Products\Product;
use Illuminate\Support\Collection;
use Tests\TestCase;

class HomeFeatureTest extends TestCase
{
    /** @test */
    public function it_should_show_the_homepage()
    {
        $cat1 = factory(Category::class)->create([
            'name' => 'New Arrivals',
            'slug' => 'new-arrivals',
            'status' => 1
        ]);

        factory(Product::class, 3)->create()->each(function (Product $product) use ($cat1) {
            $cat1Repo = new CategoryRepository($cat1);
            $cat1Repo->associateProduct($product);
        });

        $cat2 = factory(Category::class)->create([
            'name' => 'Featured',
            'slug' => 'featured',
            'status' => 1
        ]);

        factory(Product::class, 3)->create()->each(function (Product $product) use ($cat2) {
            $cat2Repo = new CategoryRepository($cat2);
            $cat2Repo->associateProduct($product);
        });

        $this
            ->get(route('home'))
            ->assertSee('Login')
            ->assertSee('Register')
            ->assertSee($cat1->name)
            ->assertSee($cat2->name)
            ->assertStatus(200);
    }

    /** @test */
    public function change_method_is_not_empty()
    {
        $cat1 = factory(Category::class)->create([
            'name' => 'New Arrivals',
            'slug' => 'new-arrivals',
            'status' => 1
        ]);

        factory(Product::class, 3)->create()->each(function (Product $product) use ($cat1) {
            $cat1Repo = new CategoryRepository($cat1);
            $cat1Repo->associateProduct($product);
        });

        $cat2 = factory(Category::class)->create([
            'name' => 'Featured',
            'slug' => 'featured',
            'status' => 1
        ]);

        factory(Product::class, 3)->create()->each(function (Product $product) use ($cat2) {
            $cat2Repo = new CategoryRepository($cat2);
            $cat2Repo->associateProduct($product);
        });


        //assert
        $this->assertInstanceOf(Collection::class, $cat1->products);
        $this->assertNotEmpty($cat1->products);
        $this->assertTrue(!$cat1->products->isEmpty());
        $this->assertTrue($cat2->products->isNotEmpty());

    }


}

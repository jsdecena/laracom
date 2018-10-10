<?php

namespace Tests\Feature\Front\Products;

use App\Shop\Products\Product;
use Tests\TestCase;

class FrontProductFeatureTest extends TestCase
{
    /** @test */
    public function it_can_show_the_product()
    {
        $product = factory(Product::class)->create();

        $this
            ->get(route('front.get.product', str_slug($product->name)))
            ->assertStatus(200)
            ->assertSee($product->name)
            ->assertSee($product->description)
            ->assertSee("$product->quantity")
            ->assertSee("$product->price");
    }

    /** @test */
    public function it_should_not_throw_error_even_the_query_is_empty()
    {
        $product = factory(Product::class)->create();

        $this
            ->get(route('search.product', ['q' => '']))
            ->assertStatus(200)
            ->assertSee($product->name)
            ->assertSee("$product->quantity")
            ->assertSee("$product->price");
    }
    
    /** @test */
    public function it_can_search_for_a_product()
    {
        $product = factory(Product::class)->create();

        $this
            ->get(route('search.product', ['q' => str_limit($product->name, 4, '')]))
            ->assertStatus(200)
            ->assertSee($product->name)
            ->assertSee("$product->quantity")
            ->assertSee("$product->price");
    }
}

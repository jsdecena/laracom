<?php

namespace Tests\Feature;

use App\Shop\Products\Product;
use Tests\TestCase;

class CartFeatureTest extends TestCase 
{
    /** @test */
    public function it_errors_when_adding_a_product_to_cart_without_the_product()
    {
        $data = [
            'quantity' => 1
        ];

        $this
            ->post(route('cart.store', $data))
            ->assertStatus(302)
            ->assertSessionHasErrors(['product' => 'The product field is required.']);
    }

    /** @test */
    public function it_errors_when_adding_a_product_to_cart_without_the_quantity()
    {
        $product = factory(Product::class)->create();

        $data = [
            'product' => $product->id
        ];

        $this
            ->post(route('cart.store', $data))
            ->assertStatus(302)
            ->assertSessionHasErrors(['quantity' => 'The quantity field is required.']);
    }
    
    /** @test */
    public function it_can_add_to_cart()
    {
        $product = factory(Product::class)->create();

        $data = [
            'product' => $product->id,
            'quantity' => 1
        ];

        $this
            ->post(route('cart.store', $data))
            ->assertStatus(302)
            ->assertSessionHas('message', 'Add to cart successful')
            ->assertRedirect(route('cart.index'));
    }
}
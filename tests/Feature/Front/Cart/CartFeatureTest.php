<?php

namespace Tests\Feature\Front\Cart;

use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\ShoppingCart;
use App\Shop\Products\Product;
use Tests\TestCase;

class CartFeatureTest extends TestCase
{
    /** @test */
    public function it_can_remove_the_item_in_the_cart()
    {
        $product = factory(Product::class)->create();

        $data = [
            'product' => $product->id,
            'quantity' => 1
        ];

        $this
            ->actingAs($this->customer, 'web')
            ->post(route('cart.store', $data));

        $cartRepo = new CartRepository(new ShoppingCart());
        $items = $cartRepo->getCartItems();

        $items->each(function ($item) {
            $this
                ->actingAs($this->customer, 'web')
                ->delete(route('cart.destroy', $item->rowId))
                ->assertStatus(302)
                ->assertRedirect(route('cart.index'))
                ->assertSessionHas('message', 'Removed to cart successful');
        });
    }
    
    /** @test */
    public function it_can_update_the_cart()
    {
        $product = factory(Product::class)->create();

        $data = [
            'product' => $product->id,
            'quantity' => 1
        ];

        $this
            ->actingAs($this->customer, 'web')
            ->post(route('cart.store', $data));

        $cartRepo = new CartRepository(new ShoppingCart());
        $items = $cartRepo->getCartItems();

        $items->each(function ($item) {
            $this
                ->actingAs($this->customer, 'web')
                ->put(route('cart.update', $item->rowId), ['quantity' => 1])
                ->assertStatus(302)
                ->assertRedirect(route('cart.index'))
                ->assertSessionHas('message', 'Update cart successful');
        });
    }
    
    /** @test */
    public function it_can_show_the_customer_cart()
    {
        $product = factory(Product::class)->create();

        $data = [
            'product' => $product->id,
            'quantity' => 1
        ];

        $this
            ->actingAs($this->customer, 'web')
            ->post(route('cart.store', $data));

        $this
            ->actingAs($this->customer, 'web')
            ->get(route('cart.index'))
            ->assertStatus(200)
            ->assertSee($product->name);
    }
    
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

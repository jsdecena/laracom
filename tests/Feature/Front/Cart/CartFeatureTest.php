<?php

namespace Tests\Feature\Front\Cart;

use App\Shop\Addresses\Address;
use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\ShoppingCart;
use App\Shop\Cities\City;
use App\Shop\Customers\Customer;
use App\Shop\ProductAttributes\ProductAttribute;
use App\Shop\Products\Product;
use Illuminate\Auth\Events\Lockout;
use Tests\TestCase;

class CartFeatureTest extends TestCase
{
    /** @test */
    public function it_can_see_the_success_page()
    {
        $this
            ->actingAs($this->customer, 'web')
            ->get(route('checkout.success'))
            ->assertStatus(200);
    }

    /** @test */
    public function it_can_see_the_cancel_page()
    {
        $this
            ->actingAs($this->customer, 'web')
            ->get(route('checkout.cancel'))
            ->assertStatus(200);
    }

    /** @test */
    public function it_can_add_to_cart_products_with_combination()
    {
        $product = factory(Product::class)->create();

        $productAttribute = factory(ProductAttribute::class)->create([
            'product_id' => $product->id
        ]);

        $data = [
            'product' => $product->id,
            'quantity' => 1,
            'productAttribute' => $productAttribute->id
        ];

        $this
            ->post(route('cart.store', $data))
            ->assertStatus(302)
            ->assertSessionHas('message', 'Add to cart successful')
            ->assertRedirect(route('cart.index'));
    }

    /** @test */
    public function it_shows_the_checkout_page_after_successful_login()
    {
        $data = ['email' => $this->customer->email, 'password' => 'secret'];

        $this
            ->post(route('cart.login'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('checkout.index'));
    }

    /** @test */
    public function it_throws_the_too_many_login_attempts_event()
    {
        $this->expectsEvents(Lockout::class);

        $customer = factory(Customer::class)->create();

        for ($i=0; $i <= 5; $i++) {
            $data = [
                'email' => $customer->email,
                'password' => 'unknown'
            ];

            $this->post(route('cart.login'), $data);
        }
    }

    /** @test */
    public function it_shows_the_login_form_when_checking_out()
    {
        $this->get(route('cart.login'))
            ->assertStatus(200)
            ->assertSee('Email')
            ->assertSee('Password')
            ->assertSee('Login now')
            ->assertSee('I forgot my password');
    }

    /** @test */
    public function it_shows_error_page_when_checking_out_without_item_in_the_cart()
    {
        $this
            ->actingAs($this->customer, 'checkout')
            ->get(route('checkout.index'))
            ->assertStatus(200)
            ->assertSee('No products in cart yet.')
            ->assertSee('Show now!');
    }

    /** @test */
    public function it_errors_when_customer_has_no_address_yet_upon_checkout()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);

        $this
            ->actingAs($this->customer, 'checkout')
            ->get(route('checkout.index'))
            ->assertStatus(200)
            ->assertSee('No address found. You need to create an address first here.');
    }

    /** @test */
    public function it_shows_the_checkout_page_when_user_is_logged_in()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);

        factory(City::class)->create();

        factory(Address::class)->create([
            'customer_id' => $this->customer->id
        ]);

        $this
            ->actingAs($this->customer, 'checkout')
            ->get(route('checkout.index'))
            ->assertStatus(200)
            ->assertSee('Billing Address')
            ->assertSee('Delivery Address')
            ->assertSee('Choose payment')
            ->assertSee('Cover')
            ->assertSee('Name')
            ->assertSee('Quantity')
            ->assertSee('Price')
            ->assertSee('Subtotal')
            ->assertSee('Shipping')
            ->assertSee('Tax')
            ->assertSee('Total');
    }

    /** @test */
    public function it_redirects_to_login_screen_when_checking_out_while_you_are_still_logged_out()
    {
        $this
            ->get(route('checkout.index'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

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

<?php

namespace Tests\Unit\OrderAddress;

use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\ShoppingCart;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\OrderRepository;
use Tests\TestCase;

class OrderAddressUnitTest extends TestCase
{
    /** @test */
    public function it_can_associate_the_order_to_address()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $qty = 1;
        $cartRepo->addToCart($this->product, $qty);
        $cartRepo->saveCart($this->customer);

        $order = factory(Order::class)->create();

        $orderRepo = new OrderRepository($order);
        $orderRepo->buildOrderDetails($cartRepo->getCartItems(), $qty);

        $orderRepo->listOrderedProducts()->each(function ($product) {
            $this->assertEquals($this->product->name, $product->name);
            $this->assertEquals($this->product->sku, $product->sku);
            $this->assertEquals($this->product->description, $product->description);
            $this->assertEquals($this->product->price, $product->price);
        });
    }
}

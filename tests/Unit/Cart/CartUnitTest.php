<?php

namespace Tests\Unit\Cart;

use App\Shop\Carts\Exceptions\ProductInCartNotFoundException;
use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\ShoppingCart;
use Gloudemans\Shoppingcart\CartItem;
use Gloudemans\Shoppingcart\Exceptions\InvalidRowIDException;
use Tests\TestCase;

class CartUnitTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_the_saved_cart_from_database()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);
        $cartRepo->saveCart($this->customer);

        // retrieve the saved cart from database
        $cartRepo2 = new CartRepository(new ShoppingCart);
        $cartRepo2->openCart($this->customer);

        $savedCartItem = $cartRepo->getCartItems()->first();
        $cartItemFromDb = $cartRepo2->getCartItems()->first();

        $this->assertInstanceOf(CartItem::class, $cartItemFromDb);
        $this->assertEquals($savedCartItem->name, $cartItemFromDb->name);
        $this->assertEquals($savedCartItem->price, $cartItemFromDb->price);
        $this->assertEquals($savedCartItem->qty, $cartItemFromDb->qty);
    }

    /** @test */
    public function it_can_store_the_cart_in_database()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);
        $cartRepo->saveCart($this->customer);

        $this->assertDatabaseHas('shoppingcart', [
            'identifier' => $this->customer->email,
            'instance' => 'default',
            'content' => serialize($cartRepo->getCartItems())
        ]);
    }

    /** @test */
    public function it_can_clear_out_your_cart()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);

        $this->assertCount(1, $cartRepo->getCartItems());

        $cartRepo->clearCart();
        $this->assertCount(0, $cartRepo->getCartItems());
    }

    /** @test */
    public function it_returns_all_the_items_in_the_cart()
    {
        $qty = 1;
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, $qty);

        $lists = $cartRepo->getCartItems();

        foreach ($lists as $list) {
            $this->assertEquals($this->product->name, $list->name);
            $this->assertEquals($this->product->price, $list->price);
            $this->assertEquals($qty, $list->qty);
        }
    }

    /** @test */
    public function it_can_show_the_specific_item_in_the_cart()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);
        $items = $cartRepo->getCartItems();

        $product = [];
        foreach ($items as $item) {
            $product[] = $cartRepo->findItem($item->rowId);
        }

        $this->assertEquals($product[0]->name, $this->product->name);
    }

    /** @test */
    public function it_can_update_the_cart_qty_in_the_cart()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);

        $items = $cartRepo->getCartItems();

        $rowId = [];
        foreach ($items as $item) {
            $rowId[] = $item->rowId;
            $cartRepo->updateQuantityInCart($item->rowId, 3);
        }

        $this->assertEquals(3, $cartRepo->findItem($rowId[0])->qty);
    }

    /** @test */
    public function it_can_return_the_total_value_of_the_items_in_the_cart()
    {
        $qty = 3;
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, $qty);
        $total = $cartRepo->getTotal();
        $totalPrice = $this->product->price * $qty;
        $grandTotal = $totalPrice + $cartRepo->getTax();

        $this->assertEquals($grandTotal, $total);
    }

    /** @test */
    public function it_can_return_the_sub_total_of_the_items()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);
        $cartRepo->addToCart($this->product, 1);
        $subtotal = $cartRepo->getSubTotal();

        $this->assertEquals(10, $subtotal);
    }

    /** @test */
    public function it_can_count_the_total_items_in_the_cart()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);
        $count = $cartRepo->countItems();

        $this->assertEquals(1, $count);
    }

    /** @test */
    public function it_errors_when_removing_item_in_the_cart_with_cart_rowID_not_existing()
    {
        $this->expectException(ProductInCartNotFoundException::class);

        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);
        $cartRepo->removeToCart('unknown');
    }

    /** @test */
    public function it_can_remove_item_in_the_cart()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);

        $items = $cartRepo->getCartItems();

        foreach ($items as $item) {
            $this->expectException(InvalidRowIDException::class);
            $cartRepo->removeToCart($item->rowId);
            $cartRepo->findItem($item->rowId);
        }
    }

    /** @test */
    public function it_can_add_to_cart()
    {
        $cartRepo = new CartRepository(new ShoppingCart);
        $cartRepo->addToCart($this->product, 1);
        $items = $cartRepo->getCartItems();

        foreach ($items as $item) {
            $this->assertEquals($this->product->name, $item->name);
        }
    }
}

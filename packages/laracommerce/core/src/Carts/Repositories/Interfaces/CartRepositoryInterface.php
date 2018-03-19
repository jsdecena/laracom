<?php

namespace Laracommerce\Core\Carts\Repositories\Interfaces;

use Laracommerce\Core\Base\Interfaces\BaseRepositoryInterface;
use Laracommerce\Core\Couriers\Courier;
use Laracommerce\Core\Customers\Customer;
use Laracommerce\Core\Products\Product;
use Gloudemans\Shoppingcart\CartItem;
use Illuminate\Support\Collection;

interface CartRepositoryInterface extends BaseRepositoryInterface
{
    public function addToCart(Product $product, int $int, $options = []) : CartItem;

    public function getCartItems() : Collection;

    public function removeToCart(string $rowId);

    public function countItems() : int;

    public function getSubTotal(int $decimals = 2);

    public function getTotal(int $decimals = 2, $shipping = 0.00);

    public function updateQuantityInCart(string $rowId, int $quantity) : CartItem;

    public function findItem(string $rowId) : CartItem;

    public function getTax(int $decimals = 2);

    public function getShippingFee(Courier $courier);

    public function clearCart();

    public function saveCart(Customer $customer, $instance = 'default');

    public function openCart(Customer $customer, $instance = 'default');

    public function getCartItemsTransformed() : Collection;
}

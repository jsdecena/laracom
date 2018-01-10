<?php

namespace App\Shop\Carts\Repositories\Interfaces;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Products\Product;

interface CartRepositoryInterface extends BaseRepositoryInterface
{
    public function addToCart(Product $product, int $int, $options = []);

    public function getCartItems();

    public function removeToCart(string $rowId);

    public function countItems() : int;

    public function getSubTotal();

    public function getTotal(int $decimals = 2);

    public function updateQuantityInCart(string $rowId, int $quantity);

    public function findItem(string $rowId);

    public function getTax() : float;

    public function clearCart();
}
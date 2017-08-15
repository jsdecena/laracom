<?php

namespace App\Carts\Repositories\Interfaces;

use App\Base\Interfaces\BaseRepositoryInterface;
use App\Products\Product;

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
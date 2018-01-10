<?php

namespace App\Shop\OrderDetails\Repositories\Interfaces;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Orders\Order;
use App\Shop\Products\Product;

interface OrderDetailRepositoryInterface extends BaseRepositoryInterface
{
    public function createOrderDetail(Order $order, Product $product, int $quantity);
}
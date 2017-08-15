<?php

namespace App\OrderDetails\Repositories\Interfaces;

use App\Base\Interfaces\BaseRepositoryInterface;
use App\Orders\Order;
use App\Products\Product;

interface OrderDetailRepositoryInterface extends BaseRepositoryInterface
{
    public function createOrderDetail(Order $order, Product $product, int $quantity);
}
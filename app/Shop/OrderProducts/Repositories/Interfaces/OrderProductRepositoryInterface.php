<?php

namespace App\Shop\OrderDetails\Repositories\Interfaces;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Orders\Order;
use App\Shop\Products\Product;
use Illuminate\Support\Collection;

interface OrderProductRepositoryInterface extends BaseRepositoryInterface
{
    public function createOrderDetail(Order $order, Product $product, int $quantity);

    public function buildOrderDetails(Order $order, Collection $collection);
}

<?php

namespace Laracommerce\Core\OrderDetails\Repositories\Interfaces;

use Laracommerce\Core\Base\Interfaces\BaseRepositoryInterface;
use Laracommerce\Core\Orders\Order;
use Laracommerce\Core\Products\Product;
use Illuminate\Support\Collection;

interface OrderProductRepositoryInterface extends BaseRepositoryInterface
{
    public function createOrderDetail(Order $order, Product $product, int $quantity);

    public function buildOrderDetails(Order $order, Collection $collection);
}

<?php

namespace Laracommerce\Core\OrderStatuses\Repositories\Interfaces;

use Laracommerce\Core\Base\Interfaces\BaseRepositoryInterface;
use Laracommerce\Core\OrderStatuses\OrderStatus;
use Illuminate\Support\Collection;

interface OrderStatusRepositoryInterface extends BaseRepositoryInterface
{
    public function createOrderStatus(array $orderStatusData) : OrderStatus;

    public function updateOrderStatus(array $update) : OrderStatus;

    public function findOrderStatusById(int $id) : OrderStatus;

    public function listOrderStatuses();

    public function deleteOrderStatus(OrderStatus $os) : bool;

    public function findOrders(): Collection;
}

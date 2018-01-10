<?php

namespace App\Shop\OrderStatuses\Repositories\Interfaces;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\OrderStatuses\OrderStatus;

interface OrderStatusRepositoryInterface extends BaseRepositoryInterface
{
    public function createOrderStatus(array $orderStatusData) : OrderStatus;

    public function updateOrderStatus(array $update) : OrderStatus;

    public function findOrderStatusById(int $id) : OrderStatus;

    public function listOrderStatuses();

    public function deleteOrderStatus(OrderStatus $os) : bool;
}
<?php

namespace App\Orders\Repositories\Interfaces;

use App\Base\Interfaces\BaseRepositoryInterface;
use App\Orders\Order;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function createOrder(array $data) : Order;

    public function updateOrder(array $update) : Order;

    public function findOrderById(int $id) : Order;

    public function listOrders(string $order = 'id', string $sort = 'desc') : Collection;

    public function findProducts(Order $order);
}
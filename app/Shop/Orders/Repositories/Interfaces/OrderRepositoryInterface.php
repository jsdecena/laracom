<?php

namespace App\Shop\Orders\Repositories\Interfaces;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Orders\Order;
use App\Shop\Products\Product;
use Illuminate\Support\Collection;

interface OrderRepositoryInterface extends BaseRepositoryInterface
{
    public function createOrder(array $data) : Order;

    public function updateOrder(array $update) : Order;

    public function findOrderById(int $id) : Order;

    public function listOrders(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection;

    public function findProducts(Order $order) : Collection;

    public function associateProduct(Product $product, int $quantity);

    public function searchOrder(string $text) : Collection;

    public function listOrderedProducts() : Collection;
}

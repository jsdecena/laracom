<?php

namespace App\OrderDetails\Repositories;

use App\Base\BaseRepository;
use App\OrderDetails\Exceptions\OrderDetailInvalidArgumentException;
use App\OrderDetails\OrderProduct;
use App\OrderDetails\Repositories\Interfaces\OrderDetailRepositoryInterface;
use App\Orders\Order;
use App\Products\Product;
use Illuminate\Database\QueryException;

class OrderProductRepository extends BaseRepository implements OrderDetailRepositoryInterface
{
    public function __construct(OrderProduct $orderDetail)
    {
        $this->model = $orderDetail;
    }

    /**
     * Create the order detail
     *
     * @param Order $order
     * @param Product $product
     * @param int $quantity
     * @return mixed
     * @throws OrderDetailInvalidArgumentException
     */
    public function createOrderDetail(Order $order, Product $product, int $quantity)
    {
        $order->products()->attach([$product->id => ['quantity' => $quantity]]);
        return $order->products;
    }
}
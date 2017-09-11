<?php

namespace App\OrderDetails\Repositories;

use App\Base\BaseRepository;
use App\OrderDetails\Exceptions\OrderDetailInvalidArgumentException;
use App\OrderDetails\OrderProduct;
use App\OrderDetails\Repositories\Interfaces\OrderDetailRepositoryInterface;
use App\Orders\Order;
use App\Orders\Repositories\OrderRepository;
use App\Products\Product;
use App\Products\Repositories\ProductRepository;

class OrderProductRepository extends BaseRepository implements OrderDetailRepositoryInterface
{
    public function __construct(OrderProduct $orderDetail)
    {
        parent::__construct($orderDetail);
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
        $orderRepo = new OrderRepository($order);
        $orderRepo->associateProduct($product, $quantity);
        return $orderRepo->findProducts($order);
    }
}
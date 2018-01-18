<?php

namespace App\Shop\OrderDetails\Repositories;

use App\Shop\Base\BaseRepository;
use App\Shop\OrderDetails\Exceptions\OrderDetailInvalidArgumentException;
use App\Shop\OrderDetails\OrderProduct;
use App\Shop\OrderDetails\Repositories\Interfaces\OrderDetailRepositoryInterface;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;

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

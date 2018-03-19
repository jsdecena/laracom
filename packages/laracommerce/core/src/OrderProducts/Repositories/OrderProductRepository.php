<?php

namespace Laracommerce\Core\OrderDetails\Repositories;

use Laracommerce\Core\Base\BaseRepository;
use Laracommerce\Core\OrderDetails\Exceptions\OrderDetailInvalidArgumentException;
use Laracommerce\Core\OrderDetails\OrderProduct;
use Laracommerce\Core\OrderDetails\Repositories\Interfaces\OrderProductRepositoryInterface;
use Laracommerce\Core\Orders\Order;
use Laracommerce\Core\Orders\Repositories\OrderRepository;
use Laracommerce\Core\Products\Product;
use Laracommerce\Core\Products\Repositories\ProductRepository;
use Illuminate\Support\Collection;

class OrderProductRepository extends BaseRepository implements OrderProductRepositoryInterface
{
    /**
     * OrderProductRepository constructor.
     * @param OrderProduct $orderDetail
     */
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

    /**
     * @param Order $order
     * @param Collection $collection
     */
    public function buildOrderDetails(Order $order, Collection $collection)
    {
        $collection->each(function ($item) use ($order) {
            $productRepo = new ProductRepository(new Product());
            $product = $productRepo->find($item->id);

            $orderDetailRepo = new OrderProductRepository(new OrderProduct);
            $orderDetailRepo->createOrderDetail($order, $product, $item->qty);
        });
    }
}

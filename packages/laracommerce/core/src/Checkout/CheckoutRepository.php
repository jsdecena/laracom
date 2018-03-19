<?php

namespace Laracommerce\Core\Checkout;

use Laracommerce\Core\Carts\Repositories\CartRepository;
use Laracommerce\Core\Carts\ShoppingCart;
use Laracommerce\Core\OrderDetails\OrderProduct;
use Laracommerce\Core\OrderDetails\Repositories\OrderProductRepository;
use Laracommerce\Core\Orders\Order;
use Laracommerce\Core\Orders\Repositories\OrderRepository;

class CheckoutRepository
{
    /**
     * @param array $data
     * @return Order
     */
    public function buildCheckoutItems(array $data) : Order
    {
        $orderRepo = new OrderRepository(new Order);
        $cartRepo = new CartRepository(new ShoppingCart);
        $orderProductRepo = new OrderProductRepository(new OrderProduct);

        $order = $orderRepo->create([
            'reference' => $data['reference'],
            'courier_id' => $data['courier_id'],
            'customer_id' => $data['customer_id'],
            'address_id' => $data['address_id'],
            'order_status_id' => $data['order_status_id'],
            'payment' => $data['payment'],
            'discounts' => $data['discounts'],
            'total_products' => $data['total_products'],
            'total' => $data['total'],
            'total_paid' => $data['total_paid'],
            'tax' => $data['tax']
        ]);

        $orderProductRepo->buildOrderDetails($order, $cartRepo->getCartItems());

        return $order;
    }
}

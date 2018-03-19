<?php

namespace Laracommerce\Core\Orders\Transformers;

use Laracommerce\Core\Addresses\Address;
use Laracommerce\Core\Addresses\Repositories\AddressRepository;
use Laracommerce\Core\Couriers\Courier;
use Laracommerce\Core\Couriers\Repositories\CourierRepository;
use Laracommerce\Core\Customers\Customer;
use Laracommerce\Core\Customers\Repositories\CustomerRepository;
use Laracommerce\Core\Orders\Order;
use Laracommerce\Core\OrderStatuses\OrderStatus;
use Laracommerce\Core\OrderStatuses\Repositories\OrderStatusRepository;

trait OrderTransformable
{
    /**
     * Transform the order
     *
     * @param Order $order
     * @return Order
     */
    protected function transformOrder(Order $order) : Order
    {
        $courierRepo = new CourierRepository(new Courier());
        $order->courier = $courierRepo->findCourierById($order->courier_id);

        $customerRepo = new CustomerRepository(new Customer());
        $order->customer = $customerRepo->findCustomerById($order->customer_id);

        $addressRepo = new AddressRepository(new Address());
        $order->address = $addressRepo->findAddressById($order->address_id);

        $orderStatusRepo = new OrderStatusRepository(new OrderStatus());
        $order->status = $orderStatusRepo->findOrderStatusById($order->order_status_id);

        return $order;
    }
}

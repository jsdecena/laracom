<?php

namespace App\Shop\Orders\Transformers;

use App\Shop\Addresses\Address;
use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Couriers\Courier;
use App\Shop\Couriers\Repositories\CourierRepository;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Orders\Order;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;

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

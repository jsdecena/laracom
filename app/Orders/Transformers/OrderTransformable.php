<?php

namespace App\Orders\Transformers;

use App\Addresses\Address;
use App\Addresses\Repositories\AddressRepository;
use App\Couriers\Courier;
use App\Couriers\Repositories\CourierRepository;
use App\Customers\Customer;
use App\Customers\Repositories\CustomerRepository;
use App\Orders\Order;
use App\OrderStatuses\OrderStatus;
use App\OrderStatuses\Repositories\OrderStatusRepository;
use App\PaymentMethods\PaymentMethod;
use App\PaymentMethods\Repositories\PaymentMethodRepository;

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

        $paymentMethod = new PaymentMethodRepository(new PaymentMethod());
        $order->payment = $paymentMethod->findPaymentMethodById($order->payment_method_id);

        return $order;
    }
}
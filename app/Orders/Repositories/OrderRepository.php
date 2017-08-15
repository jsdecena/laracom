<?php

namespace App\Orders\Repositories;

use App\Addresses\Address;
use App\Addresses\Repositories\AddressRepository;
use App\Base\BaseRepository;
use App\Couriers\Courier;
use App\Couriers\Repositories\CourierRepository;
use App\Customers\Customer;
use App\Customers\Repositories\CustomerRepository;
use App\Orders\Exceptions\OrderInvalidArgumentException;
use App\Orders\Exceptions\OrderNotFoundException;
use App\Orders\Order;
use App\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\OrderStatuses\OrderStatus;
use App\OrderStatuses\Repositories\OrderStatusRepository;
use App\PaymentMethods\PaymentMethod;
use App\PaymentMethods\Repositories\PaymentMethodRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $order)
    {
        $this->model = $order;
    }

    /**
     * Create the order
     *
     * @param array $params
     * @return Order
     * @throws OrderInvalidArgumentException
     */
    public function createOrder(array $params) : Order
    {
        try {
            return $this->create($params);
        } catch (QueryException $e) {
            throw new OrderInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param array $params
     * @return Order
     * @throws OrderInvalidArgumentException
     */
    public function updateOrder(array $params) : Order
    {
        try {
            $this->update($params, $this->model->id);
            return $this->find($this->model->id);
        } catch (QueryException $e) {
            throw new OrderInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * @param int $id
     * @return Order
     * @throws OrderNotFoundException
     */
    public function findOrderById(int $id) : Order
    {
        try {
            $order = $this->findOneOrFail($id);
            return $this->transformOrder($order);
        } catch (ModelNotFoundException $e) {
            throw new OrderNotFoundException($e->getMessage());
        }
    }


    /**
     * Return all the orders
     *
     * @param string $order
     * @param string $sort
     * @return Collection
     */
    public function listOrders(string $order = 'id', string $sort = 'desc') : Collection
    {
        $orders = $this->model->orderBy($order, $sort)->get();

        return collect($orders)->map(function ($order) {
           return $this->transformOrder($order);
        });
    }

    /**
     * Transform the order
     *
     * @param Order $order
     * @return Order
     */
    private function transformOrder(Order $order)
    {
        $prop = new Order;
        $prop->id = (int) $order->id;
        $prop->reference = $order->reference;

        $courierRepo = new CourierRepository(new Courier);
        $prop->courier = $courierRepo->findCourierById($order->courier_id);

        $customerRepo = new CustomerRepository(new Customer);
        $prop->customer = $customerRepo->findCustomerById($order->customer_id);

        $addressRepo = new AddressRepository(new Address);
        $prop->address = $addressRepo->findAddressById($order->address_id);

        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $prop->orderStatus = $orderStatusRepo->findOrderStatusById($order->order_status_id);

        $paymentMethodRepo = new PaymentMethodRepository(new PaymentMethod);
        $prop->paymentMethod = $paymentMethodRepo->findPaymentMethodById($order->payment_method_id);

        $prop->discounts = $order->discounts;
        $prop->total_products = $order->total_products;
        $prop->tax = $order->tax;
        $prop->total = $order->total;
        $prop->total_paid = $order->total_paid;
        $prop->invoice = $order->invoice;
        $prop->created_at = $order->created_at;
        $prop->updated_at = $order->updated_at;

        return $prop;
    }

    public function findProducts(Order $order)
    {
        return $order->products;
    }
}
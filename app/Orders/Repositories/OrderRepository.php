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
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function __construct(Order $order)
    {
        parent::__construct($order);
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
            throw new OrderInvalidArgumentException($e->getMessage(), 500, $e);
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
            return $this->findOneOrFail($id);
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
        return $this->model->orderBy($order, $sort)->get();
    }

    public function findProducts(Order $order)
    {
        return $order->products;
    }
}
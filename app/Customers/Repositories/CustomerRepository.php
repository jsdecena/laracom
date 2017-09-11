<?php

namespace App\Customers\Repositories;

use App\Addresses\Address;
use App\Base\BaseRepository;
use App\Customers\Customer;
use App\Customers\Exceptions\CreateCustomerInvalidArgumentException;
use App\Customers\Exceptions\CustomerNotFoundException;
use App\Customers\Exceptions\UpdateCustomerInvalidArgumentException;
use App\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    /**
     * CustomerRepository constructor.
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        parent::__construct($customer);
    }

    /**
     * List all the employees
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return \Illuminate\Support\Collection
     */
    public function listCustomers(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : \Illuminate\Support\Collection
    {
        return $this->model->orderBy($order, $sort)->get($columns);
    }

    /**
     * Create the customer
     *
     * @param array $params
     * @return Customer
     */
    public function createCustomer(array $params) : Customer
    {
        try {

            $data = collect($params)->except('password')->all();

            $customer = new Customer($data);
            if (isset($params['password'])) {
                $customer->password = bcrypt($params['password']);
            }

            $customer->save();

            return $customer;
        } catch (QueryException $e) {
            throw new CreateCustomerInvalidArgumentException('Cannot create customer', 500, $e);
        }
    }

    /**
     * Update the customer
     *
     * @param array $params
     * @return bool
     */
    public function updateCustomer(array $params) : bool
    {
        try {
            return $this->model->update($params);
        } catch (QueryException $e) {
            throw new UpdateCustomerInvalidArgumentException('Cannot update customer', 500, $e);
        }
    }

    /**
     * Find the customer or fail
     *
     * @param int $id
     * @return Customer
     */
    public function findCustomerById(int $id) : Customer
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CustomerNotFoundException('Cannot find customer', $e);
        }
    }

    /**
     * Delete a customer
     *
     * @return bool
     */
    public function deleteCustomer() : bool
    {
        return $this->model->delete();
    }

    /**
     * @param Address $address
     * @return Address
     */
    public function attachAddress(Address $address) : Address
    {
        return $this->model->addresses()->save($address);
    }

    /**
     * Find the address attached to the customer
     *
     * @return mixed
     */
    public function findAddresses() : Collection
    {
        return $this->model->addresses;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findOrders() : \Illuminate\Database\Eloquent\Collection
    {
        return $this->model->orders()->get();
    }
}
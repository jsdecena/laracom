<?php

namespace App\Shop\Customers\Repositories;

use App\Shop\Addresses\Address;
use App\Shop\Base\BaseRepository;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Exceptions\CreateCustomerInvalidArgumentException;
use App\Shop\Customers\Exceptions\CustomerNotFoundException;
use App\Shop\Customers\Exceptions\UpdateCustomerInvalidArgumentException;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection as Support;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    /**
     * CustomerRepository constructor.
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        parent::__construct($customer);
        $this->model = $customer;
    }

    /**
     * List all the employees
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return \Illuminate\Support\Collection
     */
    public function listCustomers(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Support
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * Create the customer
     *
     * @param array $params
     * @return Customer
     * @throws CreateCustomerInvalidArgumentException
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
            throw new CreateCustomerInvalidArgumentException($e->getMessage(), 500, $e);
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
    public function findAddresses() : Support
    {
        return $this->model->addresses;
    }

    /**
     * @return Collection
     */
    public function findOrders() : Collection
    {
        return $this->model->orders()->get();
    }

    /**
     * @param string $text
     * @return mixed
     */
    public function searchCustomer(string $text) : Collection
    {
        return $this->model->search($text, ['name' => 10, 'email' => 5])->get();
    }
}

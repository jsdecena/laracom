<?php

namespace App\Shop\Customers\Repositories;

use App\Shop\Addresses\Address;
use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Exceptions\CreateCustomerInvalidArgumentException;
use App\Shop\Customers\Exceptions\CustomerNotFoundException;
use App\Shop\Customers\Exceptions\CustomerPaymentChargingErrorException;
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
     *
     * @return bool
     * @throws UpdateCustomerInvalidArgumentException
     */
    public function updateCustomer(array $params) : bool
    {
        try {
            return $this->model->update($params);
        } catch (QueryException $e) {
            throw new UpdateCustomerInvalidArgumentException($e);
        }
    }

    /**
     * Find the customer or fail
     *
     * @param int $id
     *
     * @return Customer
     * @throws CustomerNotFoundException
     */
    public function findCustomerById(int $id) : Customer
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CustomerNotFoundException($e);
        }
    }

    /**
     * Delete a customer
     *
     * @return bool
     * @throws \Exception
     */
    public function deleteCustomer() : bool
    {
        return $this->delete();
    }

    /**
     * @param Address $address
     * @return Address
     */
    public function attachAddress(Address $address) : Address
    {
        $this->model->addresses()->save($address);
        return $address;
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
     * @param array $columns
     * @param string $orderBy
     *
     * @return Collection
     */
    public function findOrders($columns = ['*'], string $orderBy = 'id') : Collection
    {
        return $this->model->orders()->get($columns)->sortByDesc($orderBy);
    }

    /**
     * @param string $text
     * @return mixed
     */
    public function searchCustomer(string $text = null) : Collection
    {
        if (is_null($text)) {
            return $this->all();
        }
        return $this->model->searchCustomer($text)->get();
    }

    /**
     * @param int $amount
     * @param array $options
     * @return \Stripe\Charge
     * @throws CustomerPaymentChargingErrorException
     */
    public function charge(int $amount, array $options)
    {
        try {
            return $this->model->charge($amount * 100, $options);
        } catch (\Exception $e) {
            throw new CustomerPaymentChargingErrorException($e);
        }
    }
}

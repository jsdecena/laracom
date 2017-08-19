<?php

namespace App\Customers\Repositories;

use App\Addresses\Address;
use App\Addresses\Transformations\AddressTransformable;
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
    use AddressTransformable;

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
     * @return array
     */
    public function listCustomers(string $order = 'id', string $sort = 'desc') : array
    {
        $list = $this->model->orderBy($order, $sort)->get();

        return collect($list)->all();
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
            $customer->password = bcrypt($params['password']);
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
            throw new UpdateCustomerInvalidArgumentException('Cannot update the customer', 500, $e);
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
            throw new CustomerNotFoundException('Cannot find the customer', $e);
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
        return collect($this->model->addresses()->get())->map(function (Address $address){
            return $this->transformAddress($address);
        });
    }
}
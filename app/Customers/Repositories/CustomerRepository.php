<?php

namespace App\Customers\Repositories;

use App\Addresses\Address;
use App\Addresses\Transformations\AddressTransformable;
use App\Base\BaseRepository;
use App\Customers\Customer;
use App\Customers\Exceptions\CustomerNotFoundException;
use App\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        $collection = collect($params);

        $customer = new Customer(($collection->except('password'))->toArray());
        $customer->password = bcrypt($collection->only('password'));
        $customer->save();

        return $customer;
    }

    /**
     * Update the customer
     *
     * @param array $params
     * @return Customer
     */
    public function updateCustomer(array $params) : Customer
    {
        $this->model->update($params);

        if (in_array('password', $params)) {
            $this->model->password = $params['password'];
        }

        $this->model->save();

        return $this->findCustomerById($this->model->id);
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
            throw new CustomerNotFoundException;
        }
    }

    /**
     * Delete a customer
     *
     * @param Customer $customer
     * @return bool
     */
    public function deleteCustomer(Customer $customer) : bool
    {
        return $this->delete($customer->id);
    }

    /**
     * @param Address $address
     * @return Address
     */
    public function attachAddress(Address $address) : Address
    {
        return $this->model->address()->save($address);
    }

    /**
     * Find the address attached to the customer
     *
     * @return mixed
     */
    public function findAddresses() : Collection
    {
        return collect($this->model->address()->get())->map(function (Address $address){
            return $this->transformAddress($address);
        });
    }
}
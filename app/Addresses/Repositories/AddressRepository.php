<?php

namespace App\Addresses\Repositories;

use App\Addresses\Address;
use App\Addresses\Exceptions\AddressInvalidArgumentException;
use App\Addresses\Exceptions\AddressNotFoundException;
use App\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Addresses\Transformations\AddressTransformable;
use App\Base\BaseRepository;
use App\Cities\Repositories\CityRepository;
use App\Countries\Repositories\CountryRepository;
use App\Customers\Customer;
use App\Customers\Repositories\CustomerRepository;
use App\Customers\Transformations\CustomerTransformable;
use App\Provinces\Repositories\ProvinceRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Jsdecena\MCPro\Models\City;
use Jsdecena\MCPro\Models\Country;
use Jsdecena\MCPro\Models\Province;

class AddressRepository extends BaseRepository implements AddressRepositoryInterface
{
    use AddressTransformable, CustomerTransformable;

    /**
     * AddressRepository constructor.
     * @param Address $address
     */
    public function __construct(Address $address)
    {
        $this->model = $address;
    }

    /**
     * Create the address
     *
     * @param array $params
     * @param Customer $customer
     * @return Address
     */
    public function createAddress(array $params, Customer $customer) : Address
    {
        try {

            $collection = collect($params)->except('_token');
            $address = new Address($collection->all());
            $this->attachToCustomer($address, $customer);
            $address->save();

            return $this->find($address->id);

        } catch (QueryException $e) {
            throw new AddressInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Attach the customer to the address
     *
     * @param Address $address
     * @param Customer $customer
     */
    public function attachToCustomer(Address $address, Customer $customer)
    {
        $customer->address()->save($address);
    }

    /**
     * @param array $update
     * @return Address
     */
    public function updateAddress(array $update): Address
    {
        $this->update($update, $this->model->id);

        return $this->findAddressById($this->model->id);
    }

    /**
     * Soft delete the address
     *
     */
    public function deleteAddress()
    {
        return $this->model->delete();
    }

    /**
     * List all the address
     *
     * @param string $order
     * @param string $sort
     * @return array
     */
    public function listAddress(string $order = 'id', string $sort = 'desc') : array
    {
        $list = $this->model->orderBy($order, $sort)->get();

        return collect($list)->map(function (Address $address) {
            return $this->transformAddress($address);
        })->all();
    }

    /**
     * Return the address
     *
     * @param int $id
     * @return Address
     */
    public function findAddressById(int $id) : Address
    {
        try {
            return $this->transformAddress($this->findOneOrFail($id));
        } catch (ModelNotFoundException $e) {
            throw new AddressNotFoundException($e->getMessage());
        }
    }

    /**
     * Return the customer owner of the address
     *
     * @return Customer
     */
    public function findCustomer() : Customer
    {
        return $this->transformCustomer($this->model->customer);
    }

    /**
     * Find customer's addresses
     *
     * @param Customer $customer
     * @return mixed
     */
    public function findCustomerAddresses(Customer $customer)
    {
        return collect($customer->address)->map(function (Address $address) {
            return $this->transformAddress($address);
        })->all();
    }
}
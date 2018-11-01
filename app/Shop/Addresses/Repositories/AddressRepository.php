<?php

namespace App\Shop\Addresses\Repositories;

use App\Shop\Addresses\Address;
use App\Shop\Addresses\Exceptions\CreateAddressErrorException;
use App\Shop\Addresses\Exceptions\AddressNotFoundException;
use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Addresses\Transformations\AddressTransformable;
use App\Shop\Cities\City;
use App\Shop\Countries\Country;
use App\Shop\Customers\Customer;
use App\Shop\Provinces\Province;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Jsdecena\Baserepo\BaseRepository;

class AddressRepository extends BaseRepository implements AddressRepositoryInterface
{
    use AddressTransformable;

    /**
     * AddressRepository constructor.
     * @param Address $address
     */
    public function __construct(Address $address)
    {
        parent::__construct($address);
        $this->model = $address;
    }

    /**
     * Create the address
     *
     * @param array $data
     *
     * @return Address
     * @throws CreateAddressErrorException
     */
    public function createAddress(array $data) : Address
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreateAddressErrorException('Address creation error');
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
        $customer->addresses()->save($address);
    }

    /**
     * @param array $data
     * @return bool
     */
    public function updateAddress(array $data): bool
    {
        return $this->update($data);
    }

    /**
     * Soft delete the address
     *
     */
    public function deleteAddress()
    {
        $this->model->customer()->dissociate();
        return $this->model->delete();
    }

    /**
     * List all the address
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return array|Collection
     */
    public function listAddress(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort);
    }

    /**
     * Return the address
     *
     * @param int $id
     *
     * @return Address
     * @throws AddressNotFoundException
     */
    public function findAddressById(int $id) : Address
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new AddressNotFoundException('Address not found.');
        }
    }

    /**
     * Return the address
     *
     * @param int $id
     *
     * @return Address
     * @throws AddressNotFoundException
     */
    public function findCustomerAddressById(int $id, Customer $customer) : Address
    {
        try 
        {
            return $customer
                        ->addresses()
                        ->whereId($id)
                        ->firstOrFail();
        } 
        catch (ModelNotFoundException $e) 
        {
            throw new AddressNotFoundException('Address not found.');
        }
    }

    /**
     * Return the customer owner of the address
     *
     * @return Customer
     */
    public function findCustomer() : Customer
    {
        return $this->model->customer;
    }

    /**
     * @param string $text
     * @return mixed
     */
    public function searchAddress(string $text = null) : Collection
    {
        if (is_null($text)) {
            return $this->all(['*'], 'address_1', 'asc');
        }
        return $this->model->searchAddress($text)->get();
    }

    /**
     * @return Country
     */
    public function findCountry() : Country
    {
        return $this->model->country;
    }

    /**
     * @return Province
     */
    public function findProvince() : Province
    {
        return $this->model->province;
    }

    public function findCity() : City
    {
        return $this->model->city;
    }

    /**
     * @return Collection
     */
    public function findOrders() : Collection
    {
        return $this->model->orders()->get();
    }
}

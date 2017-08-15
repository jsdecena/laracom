<?php

namespace App\Addresses\Repositories;

use App\Addresses\Address;
use App\Addresses\Exceptions\AddressInvalidArgumentException;
use App\Addresses\Exceptions\AddressNotFoundException;
use App\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Addresses\Transformations\AddressTransformable;
use App\Base\BaseRepository;
use App\Cities\Repositories\CityRepository;
use App\Customers\Customer;
use App\Customers\Transformations\CustomerTransformable;
use App\Provinces\Repositories\ProvinceRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use App\Cities\City;

class AddressRepository extends BaseRepository implements AddressRepositoryInterface
{
    use AddressTransformable, CustomerTransformable;

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
     * @param array $params
     * @return Address
     */
    public function createAddress(array $params) : Address
    {
        try {

            $exceptions = [
                '_token',
                'customer_id',
                'city_id',
                'country_id',
                'province_id'
            ];

            $address = new Address(collect($params)->except($exceptions)->all());

            if (isset($params['city_id'])) {
                $cityRepo = new CityRepository(new City);
                $city = $cityRepo->findCityById($params['city_id']);
                $address->city()->associate($city->id);

                $province = $city->province()->first();
                $address->province()->associate($province->id);

                $country = $province->country()->first();
                $address->country()->associate($country->id);
            }

            if (isset($params['customer_id'])) {
                $address->customer()->associate($params['customer_id']);
            }

            $address->save();

            return $address;

        } catch (QueryException $e) {
            throw new AddressInvalidArgumentException('Address creation error', 500, $e);
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
     * @return bool
     */
    public function updateAddress(array $update): bool
    {
        return $this->model->update($update);
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
     * @return array|\Illuminate\Support\Collection
     */
    public function listAddress(string $order = 'id', string $sort = 'desc') : Collection
    {
        return collect($this->model->orderBy($order, $sort)->get());
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
            return $this->findOneOrFail($id);
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
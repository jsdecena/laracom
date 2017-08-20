<?php

namespace App\Addresses\Repositories;

use App\Addresses\Address;
use App\Addresses\Exceptions\AddressInvalidArgumentException;
use App\Addresses\Exceptions\AddressNotFoundException;
use App\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Addresses\Transformations\AddressTransformable;
use App\Base\BaseRepository;
use App\Customers\Customer;
use App\Customers\Transformations\CustomerTransformable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

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

            $address = new Address($params);
            if (isset($params['customer'])) {
                $address->customer()->associate($params['customer']);
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
        $customer->addresses()->save($address);
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
        $this->model->customer()->dissociate();
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
        return $this->model->orderBy($order, $sort)->get();
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
        return $this->model->customer;
    }
}
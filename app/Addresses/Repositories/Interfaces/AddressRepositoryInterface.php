<?php

namespace App\Addresses\Repositories\Interfaces;

use App\Addresses\Address;
use App\Base\Interfaces\BaseRepositoryInterface;
use App\Customers\Customer;
use Illuminate\Support\Collection;

interface AddressRepositoryInterface extends BaseRepositoryInterface
{
    public function createAddress(array $params) : Address;

    public function attachToCustomer(Address $address, Customer $customer);

    public function updateAddress(array $update): bool;

    public function deleteAddress();

    public function listAddress(string $order = 'id', string $sort = 'desc') : Collection;

    public function findAddressById(int $id) : Address;

    public function findCustomer() : Customer;
}
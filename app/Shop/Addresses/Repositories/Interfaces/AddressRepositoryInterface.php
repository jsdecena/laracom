<?php

namespace App\Shop\Addresses\Repositories\Interfaces;

use App\Shop\Addresses\Address;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Customers\Customer;
use Illuminate\Support\Collection;

interface AddressRepositoryInterface extends BaseRepositoryInterface
{
    public function createAddress(array $params) : Address;

    public function attachToCustomer(Address $address, Customer $customer);

    public function updateAddress(array $update): bool;

    public function deleteAddress();

    public function listAddress(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection;

    public function findAddressById(int $id) : Address;

    public function findCustomer() : Customer;

    public function searchAddress(string $text) : Collection;
}
<?php

namespace App\Addresses\Repositories\Interfaces;

use App\Addresses\Address;
use App\Base\Interfaces\BaseRepositoryInterface;
use App\Customers\Customer;

interface AddressRepositoryInterface extends BaseRepositoryInterface
{
    public function createAddress(array $params, Customer $customer) : Address;

    public function attachToCustomer(Address $address, Customer $customer);

    public function updateAddress(array $update): Address;

    public function deleteAddress();

    public function listAddress(string $order = 'id', string $sort = 'desc') : array;

    public function findAddressById(int $id) : Address;

    public function findCustomer() : Customer;

    public function findCustomerAddresses(Customer $customer);
}
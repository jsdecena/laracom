<?php

namespace App\Customers\Repositories\Interfaces;

use App\Addresses\Address;
use App\Base\Interfaces\BaseRepositoryInterface;
use App\Customers\Customer;
use Illuminate\Support\Collection;

interface CustomerRepositoryInterface extends BaseRepositoryInterface
{
    public function listCustomers(string $order = 'id', string $sort = 'desc') : array;

    public function createCustomer(array $params) : Customer;

    public function updateCustomer(array $params) : Customer;

    public function findCustomerById(int $id) : Customer;

    public function deleteCustomer(Customer $customer) : bool;

    public function attachAddress(Address $address) : Address;

    public function findAddresses(Customer $customer) : Collection;
}
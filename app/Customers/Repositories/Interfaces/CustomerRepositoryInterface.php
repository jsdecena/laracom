<?php

namespace App\Customers\Repositories\Interfaces;

use App\Addresses\Address;
use App\Base\Interfaces\BaseRepositoryInterface;
use App\Customers\Customer;

interface CustomerRepositoryInterface extends BaseRepositoryInterface
{
    public function listCustomers(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : \Illuminate\Support\Collection;

    public function createCustomer(array $params) : Customer;

    public function updateCustomer(array $params) : bool;

    public function findCustomerById(int $id) : Customer;

    public function deleteCustomer() : bool;

    public function attachAddress(Address $address) : Address;

    public function findAddresses() : \Illuminate\Support\Collection;

    public function findOrders() : \Illuminate\Database\Eloquent\Collection;
}
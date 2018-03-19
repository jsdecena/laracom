<?php

namespace Laracommerce\Core\Addresses\Repositories\Interfaces;

use Laracommerce\Core\Addresses\Address;
use Laracommerce\Core\Base\Interfaces\BaseRepositoryInterface;
use Laracommerce\Core\Cities\City;
use Laracommerce\Core\Countries\Country;
use Laracommerce\Core\Customers\Customer;
use Laracommerce\Core\Provinces\Province;
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

    public function findCountry() : Country;

    public function findProvince() : Province;

    public function findCity() : City;
}

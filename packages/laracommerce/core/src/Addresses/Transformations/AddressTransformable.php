<?php

namespace Laracommerce\Core\Addresses\Transformations;

use Laracommerce\Core\Addresses\Address;
use Laracommerce\Core\Cities\Repositories\CityRepository;
use Laracommerce\Core\Countries\Repositories\CountryRepository;
use Laracommerce\Core\Customers\Customer;
use Laracommerce\Core\Customers\Repositories\CustomerRepository;
use Laracommerce\Core\Provinces\Province;
use Laracommerce\Core\Provinces\Repositories\ProvinceRepository;
use Laracommerce\Core\Cities\City;
use Laracommerce\Core\Countries\Country;

trait AddressTransformable
{
    /**
     * Transform the address
     *
     * @param Address $address
     * @return Address
     */
    public function transformAddress(Address $address)
    {
        $obj = new Address;
        $obj->id = $address->id;
        $obj->alias = $address->alias;
        $obj->address_1 = $address->address_1;
        $obj->address_2 = $address->address_2;
        $obj->zip = $address->zip;

        if (isset($address->city_id)) {
            $cityRepo = new CityRepository(new City);
            $city = $cityRepo->findCityById($address->city_id);
            $obj->city = $city->name;
        }

        if (isset($address->province_id)) {
            $provinceRepo = new ProvinceRepository(new Province);
            $province = $provinceRepo->findProvinceById($address->province_id);
            $obj->province = $province->name;
        }

        $countryRepo = new CountryRepository(new Country);
        $country = $countryRepo->findCountryById($address->country_id);
        $obj->country = $country->name;

        $customerRepo = new CustomerRepository(new Customer);
        $customer = $customerRepo->findCustomerById($address->customer_id);
        $obj->customer = $customer->name;
        $obj->status = $address->status;

        return $obj;
    }
}

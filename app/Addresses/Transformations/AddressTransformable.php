<?php

namespace App\Addresses\Transformations;

use App\Addresses\Address;
use App\Cities\Repositories\CityRepository;
use App\Countries\Repositories\CountryRepository;
use App\Customers\Customer;
use App\Customers\Repositories\CustomerRepository;
use App\Provinces\Province;
use App\Provinces\Repositories\ProvinceRepository;
use App\Cities\City;
use App\Countries\Country;

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

        $cityRepo = new CityRepository(new City);
        $city = $cityRepo->findCityById($address->city_id);
        $obj->city = $city->name;

        $provinceRepo = new ProvinceRepository(new Province);
        $province = $provinceRepo->findProvinceById($address->province_id);
        $obj->province = $province->name;

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
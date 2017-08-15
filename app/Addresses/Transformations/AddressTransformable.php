<?php

namespace App\Addresses\Transformations;

use App\Addresses\Address;
use App\Cities\Repositories\CityRepository;
use App\Countries\Repositories\CountryRepository;
use App\Provinces\Repositories\ProvinceRepository;
use Jsdecena\MCPro\Models\City;
use Jsdecena\MCPro\Models\Country;
use Jsdecena\MCPro\Models\Province;

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
        $prop = new Address;
        $prop->id = $address->id;
        $prop->alias = $address->alias;
        $prop->address_1 = $address->address_1;
        $prop->address_2 = $address->address_2;
        $prop->zip = $address->zip;

        $cityRepo = new CityRepository(new City);
        $city = $cityRepo->findCityById($address->city_id);
        $prop->city = $city;

        $provinceRepo = new ProvinceRepository(new Province);
        $province = $provinceRepo->findProvinceById($address->province_id);
        $prop->province = $province;

        $countryRepo = new CountryRepository(new Country);
        $prop->country = $countryRepo->findCountryById($address->country_id);

        $prop->customer_id = $address->customer_id;
        $prop->status = $address->status;

        return $prop;
    }
}
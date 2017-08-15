<?php

namespace App\Http\Controllers\Admin\Customers;

use App\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;

class CustomerAddressController extends Controller
{
    private $addressRepo;
    private $countryRepo;
    private $provinceRepo;

    public function __construct(
        AddressRepositoryInterface $addressRepository,
        CountryRepositoryInterface $countryRepository,
        ProvinceRepositoryInterface $provinceRepository
    )
    {
        $this->addressRepo = $addressRepository;
        $this->countryRepo = $countryRepository;
        $this->provinceRepo = $provinceRepository;
    }

    /**
     * Show the customer's address
     *
     * @param int $customerId
     * @param int $addressId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(int $customerId, int $addressId)
    {
        return view('admin.addresses.customers.show', [
            'address' => $this->addressRepo->findAddressById($addressId),
            'customerId' => $customerId
        ]);
    }

    /**
     * Show the edit form
     *
     * @param int $customerId
     * @param int $addressId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $customerId, int $addressId)
    {
        $ph = $this->countryRepo->findCountryById(169);
        $prov = $this->provinceRepo->findProvinceById(1);

        return view('admin.addresses.customers.edit', [
            'address' => $this->addressRepo->findAddressById($addressId),
            'countries' => $this->countryRepo->listCountries(),
            'provinces' => $this->countryRepo->findProvinces($ph),
            'cities' => $this->provinceRepo->listCities($prov),
            'customerId' => $customerId
        ]);
    }
}

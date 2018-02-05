<?php

namespace App\Http\Controllers\Admin\Customers;

use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Shop\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;

class CustomerAddressController extends Controller
{
    /**
     * @var AddressRepositoryInterface
     */
    private $addressRepo;
    /**
     * @var CountryRepositoryInterface
     */
    private $countryRepo;
    /**
     * @var ProvinceRepositoryInterface
     */
    private $provinceRepo;

    /**
     * CustomerAddressController constructor.
     * @param AddressRepositoryInterface $addressRepository
     * @param CountryRepositoryInterface $countryRepository
     * @param ProvinceRepositoryInterface $provinceRepository
     */
    public function __construct(
        AddressRepositoryInterface $addressRepository,
        CountryRepositoryInterface $countryRepository,
        ProvinceRepositoryInterface $provinceRepository
    ) {
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
        $this->countryRepo->findCountryById(env('COUNTRY_ID', 1));
        $province = $this->provinceRepo->findProvinceById(1);

        return view('admin.addresses.customers.edit', [
            'address' => $this->addressRepo->findAddressById($addressId),
            'countries' => $this->countryRepo->listCountries(),
            'provinces' => $this->countryRepo->findProvinces(),
            'cities' => $this->provinceRepo->listCities($province->id),
            'customerId' => $customerId
        ]);
    }
}

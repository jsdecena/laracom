<?php

namespace App\Http\Controllers\Front;

use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Addresses\Requests\CreateAddressRequest;
use App\Shop\Cities\Repositories\Interfaces\CityRepositoryInterface;
use App\Shop\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Http\Controllers\Controller;

class CustomerAddressController extends Controller
{
    private $addressRepo;
    private $customerRepo;
    private $countryRepo;
    private $cityRepo;

    public function __construct(
        AddressRepositoryInterface $addressRepository,
        CustomerRepositoryInterface $customerRepository,
        CountryRepositoryInterface $countryRepository,
        CityRepositoryInterface $cityRepository
    ) {
        $this->addressRepo = $addressRepository;
        $this->customerRepo = $customerRepository;
        $this->countryRepo = $countryRepository;
        $this->cityRepo = $cityRepository;
    }

    public function index(int $customerId)
    {
        $customer = $this->customerRepo->findCustomerById($customerId);

        return view('front.customers.addresses.list', [
            'customer' => $customer,
            'addresses' => $customer->addresses
        ]);
    }

    public function create(int $customerId)
    {
        $country = $this->countryRepo->findCountryById(env('COUNTRY_ID'));
        $countries = $this->countryRepo
                            ->listCountries()
                            ->except(env('COUNTRY_ID'))
                            ->prepend($country);

        return view('front.customers.addresses.create', [
            'customers' => $this->customerRepo->listCustomers(),
            'customer' => $this->customerRepo->findCustomerById($customerId),
            'countries' => $countries,
            'provinces' => $country->provinces,
            'cities' => $this->cityRepo->listCities()
        ]);
    }

    public function store(CreateAddressRequest $request, int $customerId)
    {
        $request['customer'] = $customerId;
        $this->addressRepo->createAddress($request->except('_token', '_method'));

        $request->session()->flash('message', 'Address creation successful');
        return redirect()->route('checkout.index');
    }
}

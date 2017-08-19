<?php

namespace App\Http\Controllers\Front;

use App\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Addresses\Requests\CreateAddressRequest;
use App\Cities\City;
use App\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use App\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Http\Controllers\Controller;

class CustomerAddressController extends Controller
{
    private $addressRepo;
    private $customerRepo;
    private $countryRepo;

    public function __construct(
        AddressRepositoryInterface $addressRepository,
        CustomerRepositoryInterface $customerRepository,
        CountryRepositoryInterface $countryRepository
    )
    {
        $this->addressRepo = $addressRepository;
        $this->customerRepo = $customerRepository;
        $this->countryRepo = $countryRepository;
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
        $countries = $this->countryRepo->listCountries();
        $philippines = $countries->find(['id' => env('COUNTRY_ID')])->first();
        $countries->prepend($philippines)->except(['id' => env('COUNTRY_ID')]);

        $country = $this->countryRepo->findCountryById($philippines->id);
        $customers = $this->customerRepo->listCustomers();
        $customer = $this->customerRepo->findCustomerById($customerId);

        return view('front.customers.addresses.create', [
            'customers' => $customers,
            'customer' => $customer,
            'countries' => $countries,
            'provinces' => $country->provinces,
            'cities' => City::all()
        ]);
    }

    public function store(CreateAddressRequest $request, int $customerId)
    {
        $request['customer'] = $customerId;
        $this->addressRepo->createAddress($request->except('_token', '_method'));

        $request->session()->flash('message', 'Address creation successful');
        return redirect()->route('customer.address.index', $customerId);
    }
}
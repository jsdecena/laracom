<?php

namespace App\Http\Controllers\Front;

use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Addresses\Requests\CreateAddressRequest;
use App\Shop\Addresses\Requests\UpdateAddressRequest;
use App\Shop\Cities\Repositories\Interfaces\CityRepositoryInterface;
use App\Shop\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;
use App\Http\Controllers\Controller;

class CustomerAddressController extends Controller
{
    /**
     * @var AddressRepositoryInterface
     */
    private $addressRepo;

    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepo;

    /**
     * @var CountryRepositoryInterface
     */
    private $countryRepo;

    /**
     * @var CityRepositoryInterface
     */
    private $cityRepo;

    /**
     * @var ProvinceRepositoryInterface
     */
    private $provinceRepo;

    public function __construct(
        AddressRepositoryInterface $addressRepository,
        CustomerRepositoryInterface $customerRepository,
        CountryRepositoryInterface $countryRepository,
        CityRepositoryInterface $cityRepository,
        ProvinceRepositoryInterface $provinceRepository
    ) {
        $this->addressRepo = $addressRepository;
        $this->customerRepo = $customerRepository;
        $this->countryRepo = $countryRepository;
        $this->cityRepo = $cityRepository;
        $this->provinceRepo = $provinceRepository;
    }

    /**
     * @param int $customerId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($customerId)
    {
        $customer = $this->customerRepo->findCustomerById($customerId);

        return view('front.customers.addresses.list', [
            'customer' => $customer,
            'addresses' => $customer->addresses
        ]);
    }

    /**
     * @param int $customerId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($customerId)
    {
        $countries = $this->countryRepo->listCountries();

        return view('front.customers.addresses.create', [
            'customer' => $this->customerRepo->findCustomerById($customerId),
            'countries' => $countries,
            'cities' => $this->cityRepo->listCities(),
            'provinces' => $this->provinceRepo->listProvinces()
        ]);
    }

    /**
     * @param CreateAddressRequest $request
     * @param int $customerId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateAddressRequest $request, $customerId)
    {
        $request['customer'] = $customerId;
        $this->addressRepo->createAddress($request->except('_token', '_method'));

        return redirect()->route('customer.address.index', $customerId)
            ->with('message', 'Address creation successful');
    }

    /**
     * @param $customerId
     * @param $addressId
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($customerId, $addressId)
    {
        $countries = $this->countryRepo->listCountries();

        return view('front.customers.addresses.edit', [
            'customer' => $this->customerRepo->findCustomerById($customerId),
            'address' => $this->addressRepo->findAddressById($addressId),
            'countries' => $countries,
            'cities' => $this->cityRepo->listCities(),
            'provinces' => $this->provinceRepo->listProvinces()
        ]);
    }

    /**
     * @param UpdateAddressRequest $request
     * @param $customerId
     * @param $addressId
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateAddressRequest $request, $customerId, $addressId)
    {
        $address = $this->addressRepo->findAddressById($addressId);

        $addressRepo = new AddressRepository($address);
        $request['customer'] = $customerId;
        $addressRepo->updateAddress($request->except('_token', '_method'));

        return redirect()->route('customer.address.edit', [$customerId, $addressId])
            ->with('message', 'Address update successful');
    }

    /**
     * @param $customerId
     * @param $addressId
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($customerId, $addressId)
    {
        $address = $this->addressRepo->findAddressById($addressId);
        $address->delete();

        return redirect()->route('customer.address.index', $customerId)
            ->with('message', 'Address delete successful');
    }
}

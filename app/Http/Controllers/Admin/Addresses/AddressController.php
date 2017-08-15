<?php

namespace App\Http\Controllers\Admin\Addresses;

use App\Addresses\Repositories\AddressRepository;
use App\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Addresses\Requests\CreateAddressRequest;
use App\Addresses\Requests\UpdateAddressRequest;
use App\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use App\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;

class AddressController extends Controller
{
    private $addressRepo;
    private $customerRepo;
    private $countryRepo;
    private $provinceRepo;

    public function __construct(
        AddressRepositoryInterface $addressRepository,
        CustomerRepositoryInterface $customerRepository,
        CountryRepositoryInterface $countryRepository,
        ProvinceRepositoryInterface $provinceRepository
    )
    {
        $this->addressRepo = $addressRepository;
        $this->customerRepo = $customerRepository;
        $this->countryRepo = $countryRepository;
        $this->provinceRepo = $provinceRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->addressRepo->listAddress('created_at', 'desc');

        return view('admin.addresses.list', [
            'addresses' => $this->addressRepo->paginateArrayResults($list, 10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $ph = $this->countryRepo->findCountryById(169);
        $prov = $this->provinceRepo->findProvinceById(1);
        $customers = $this->customerRepo->listCustomers();
        return view('admin.addresses.create', [
            'customers' => $customers,
            'countries' => $this->countryRepo->listCountries(),
            'provinces' => $this->countryRepo->findProvinces($ph),
            'cities' => $this->provinceRepo->listCities($prov)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateAddressRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAddressRequest $request)
    {
        $customer = $this->customerRepo->findCustomerById($request->input('customer_id'));
        $this->addressRepo->createAddress($request->except('customer'), $customer);

        $request->session()->flash('message', 'Creation successful');
        return redirect()->route('addresses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        return view('admin.addresses.show', ['address' => $this->addressRepo->findAddressById($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $address = $this->addressRepo->findAddressById($id);
        $ph = $this->countryRepo->findCountryById($address->country->id);
        $prov = $this->provinceRepo->findProvinceById($address->province->id);
        $customer = $this->addressRepo->findCustomer($address);

        return view('admin.addresses.edit', [
            'address' => $address,
            'countries' => $this->countryRepo->listCountries(),
            'countryId' => $address->country->id,
            'provinces' => $this->countryRepo->findProvinces($ph),
            'provinceId' => $address->province->id,
            'cities' => $this->provinceRepo->listCities($prov),
            'cityId' => $address->city->id,
            'customers' => $this->customerRepo->listCustomers(),
            'customerId' => $customer->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateAddressRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAddressRequest $request, $id)
    {
        $address = $this->addressRepo->findAddressById($id);

        $update = new AddressRepository($address);
        $update->updateAddress($request->except('_method', '_token'));

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('addresses.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

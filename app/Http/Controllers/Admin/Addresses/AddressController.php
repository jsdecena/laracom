<?php

namespace App\Http\Controllers\Admin\Addresses;

use App\Shop\Addresses\Address;
use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Addresses\Requests\CreateAddressRequest;
use App\Shop\Addresses\Requests\UpdateAddressRequest;
use App\Shop\Addresses\Transformations\AddressTransformable;
use App\Shop\Cities\City;
use App\Shop\Cities\Repositories\Interfaces\CityRepositoryInterface;
use App\Shop\Countries\Country;
use App\Shop\Countries\Repositories\CountryRepository;
use App\Shop\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Shop\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    use AddressTransformable;

    private $addressRepo;
    private $customerRepo;
    private $countryRepo;
    private $provinceRepo;
    private $cityRepo;

    public function __construct(
        AddressRepositoryInterface $addressRepository,
        CustomerRepositoryInterface $customerRepository,
        CountryRepositoryInterface $countryRepository,
        ProvinceRepositoryInterface $provinceRepository,
        CityRepositoryInterface $cityRepository
    ) {
        $this->addressRepo = $addressRepository;
        $this->customerRepo = $customerRepository;
        $this->countryRepo = $countryRepository;
        $this->provinceRepo = $provinceRepository;
        $this->cityRepo = $cityRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $list = $this->addressRepo->listAddress('created_at', 'desc');

        if ($request->has('q')) {
            $list = $this->addressRepo->searchAddress($request->input('q'));
        }

        $addresses = $list->map(function (Address $address) {
            return $this->transformAddress($address);
        })->all();

        return view('admin.addresses.list', ['addresses' => $this->addressRepo->paginateArrayResults($addresses)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = $this->countryRepo->listCountries();
        $country = $this->countryRepo->findCountryById(1);

        $customers = $this->customerRepo->listCustomers();

        return view('admin.addresses.create', [
            'customers' => $customers,
            'countries' => $countries,
            'provinces' => $country->provinces,
            'cities' => City::all()
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
        $this->addressRepo->createAddress($request->except('_token', '_method'));

        $request->session()->flash('message', 'Creation successful');
        return redirect()->route('admin.addresses.index');
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
        $countries = $this->countryRepo->listCountries();

        $country = $countries->filter(function ($country) {
            return $country == env('SHOP_COUNTRY_ID', '1');
        })->first();

        $countryRepo = new CountryRepository(new Country);
        if (!empty($country)) {
            $countryRepo = new CountryRepository($country);
        }

        $address = $this->addressRepo->findAddressById($id);
        $addressRepo = new AddressRepository($address);
        $customer = $addressRepo->findCustomer();

        return view('admin.addresses.edit', [
            'address' => $address,
            'countries' => $countries,
            'countryId' => $address->country->id,
            'provinces' => $countryRepo->findProvinces(),
            'provinceId' => $address->province->id,
            'cities' => $this->cityRepo->listCities(),
            'cityId' => $address->city_id,
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
        return redirect()->route('admin.addresses.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $address = $this->addressRepo->findAddressById($id);
        $delete = new AddressRepository($address);
        $delete->deleteAddress();

        request()->session()->flash('message', 'Delete successful');
        return redirect()->route('admin.addresses.index');
    }
}

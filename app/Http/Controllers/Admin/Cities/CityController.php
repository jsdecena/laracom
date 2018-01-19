<?php

namespace App\Http\Controllers\Admin\Cities;

use App\Shop\Cities\Repositories\CityRepository;
use App\Shop\Cities\Repositories\Interfaces\CityRepositoryInterface;
use App\Shop\Cities\Requests\UpdateCityRequest;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    private $cityRepo;

    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepo = $cityRepository;
    }

    /**
     * Show the edit form
     *
     * @param int $countryId
     * @param int $provinceId
     * @param int $cityId
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $countryId, int $provinceId, int $cityId)
    {
        $city = $this->cityRepo->findCityById($cityId);

        return view('admin.cities.edit', [
            'countryId' => $countryId,
            'provinceId' => $provinceId,
            'city' => $city
        ]);
    }

    /**
     * Update the city
     *
     * @param UpdateCityRequest $request
     * @param int $countryId
     * @param int $provinceId
     * @param int $cityId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCityRequest $request, int $countryId, int $provinceId, int $cityId)
    {
        $city = $this->cityRepo->findCityById($cityId);

        $update = new CityRepository($city);
        $update->updateCity($request->only('name'));

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.countries.provinces.cities.edit', [$countryId, $provinceId, $cityId]);
    }
}

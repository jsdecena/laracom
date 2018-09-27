<?php

namespace App\Http\Controllers\Admin\Cities;

use App\Shop\Cities\Repositories\CityRepository;
use App\Shop\Cities\Repositories\Interfaces\CityRepositoryInterface;
use App\Shop\Cities\Requests\UpdateCityRequest;
use App\Http\Controllers\Controller;

class CityController extends Controller
{
    /**
     * @var CityRepositoryInterface
     */
    private $cityRepo;

    /**
     * CityController constructor.
     *
     * @param CityRepositoryInterface $cityRepository
     */
    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepo = $cityRepository;
    }

    /**
     * Show the edit form
     *
     * @param int $countryId
     * @param int $provinceId
     * @param string $city
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($countryId, $provinceId, $city)
    {
        $city = $this->cityRepo->findCityByName($city);

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
     * @param $city
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCityRequest $request, $countryId, $provinceId, $city)
    {
        $city = $this->cityRepo->findCityByName($city);

        $update = new CityRepository($city);
        $update->updateCity($request->only('name'));

        return redirect()
            ->route('admin.countries.provinces.cities.edit', [$countryId, $provinceId, $city])
            ->with('message', 'Update successful');
    }
}

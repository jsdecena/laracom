<?php

namespace App\Http\Controllers\Admin\Provinces;

use App\Shop\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;
use App\Http\Controllers\Controller;
use App\Shop\Provinces\Repositories\ProvinceRepository;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    protected $provinceRepo;

    public function __construct(ProvinceRepositoryInterface $provinceRepository)
    {
        $this->provinceRepo = $provinceRepository;
    }

    /**
     * Display the specified resource.
     *
     * @param int $provinceId
     * @param int $countryId
     * @return \Illuminate\Http\Response
     */
    public function show(int $countryId, int $provinceId)
    {
        $province = $this->provinceRepo->findProvinceById($provinceId);
        $cities = $this->provinceRepo->listCities($provinceId);

        return view('admin.provinces.show', [
            'province' => $province,
            'countryId' => $countryId,
            'cities' => $this->provinceRepo->paginateArrayResults(collect($cities)->toArray())
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $provinceId
     * @param int $countryId
     * @return \Illuminate\Http\Response
     */
    public function edit(int $countryId, int $provinceId)
    {
        return view('admin.provinces.edit', [
            'province' => $this->provinceRepo->findProvinceById($provinceId),
            'countryId' => $countryId
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param int $provinceId
     * @param int $countryId
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $countryId, int $provinceId)
    {
        $province = $this->provinceRepo->findProvinceById($provinceId);
        $update = new ProvinceRepository($province);
        $update->updateProvince($request->except('_method', '_token'));

        $request->session()->flash('message', 'Update successful');
        return redirect()->route('admin.countries.provinces.edit', [$countryId, $provinceId]);
    }
}

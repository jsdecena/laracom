<?php

namespace App\Shop\Cities\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Cities\Exceptions\CityNotFoundException;
use App\Shop\Cities\Repositories\Interfaces\CityRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Shop\Cities\City;
use Illuminate\Support\Collection;

class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    /**
     * CityRepository constructor.
     *
     * @param City $city
     */
    public function __construct(City $city)
    {
        parent::__construct($city);
        $this->model = $city;
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return mixed
     */
    public function listCities($columns = ['*'], string $orderBy = 'name', string $sortBy = 'asc')
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    /**
     * @param int $id
     * @return City
     * @throws CityNotFoundException
     *
     * @deprecated @findCityByName
     */
    public function findCityById(int $id) : City
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CityNotFoundException('City not found.');
        }
    }

    /**
     * @param array $params
     *
     * @return boolean
     */
    public function updateCity(array $params) : bool
    {
        $this->model->update($params);
        return $this->model->save();
    }

    /**
     * @param string $state_code
     *
     * @return Collection
     */
    public function listCitiesByStateCode(string $state_code) : Collection
    {
        return $this->model->where(compact('state_code'))->get();
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws CityNotFoundException
     */
    public function findCityByName(string $name) : City
    {
        try {
            return $this->model->where(compact('name'))->firstOrFail();
        } catch (ModelNotFoundException $e) {
            throw new CityNotFoundException('City not found.');
        }
    }
}

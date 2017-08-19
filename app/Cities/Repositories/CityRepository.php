<?php

namespace App\Cities\Repositories;

use App\Base\BaseRepository;
use App\Cities\Exceptions\CityNotFoundException;
use App\Cities\Repositories\Interfaces\CityRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Cities\City;

class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    public function __construct(City $city)
    {
        parent::__construct($city);
        $this->model = $city;
    }

    public function listCities()
    {
        return $this->model->get();
    }

    /**
     * @param int $id
     * @return City
     * @throws CityNotFoundException
     */
    public function findCityById(int $id) : City
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CityNotFoundException($e->getMessage());
        }
    }

    /**
     * @param array $params
     * @return City
     */
    public function updateCity(array $params) : City
    {
        $this->model->update($params);
        $this->model->save();

        return $this->findCityById($this->model->id);
    }
}
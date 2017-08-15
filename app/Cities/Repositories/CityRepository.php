<?php

namespace App\Cities\Repositories;

use App\Base\BaseRepository;
use App\Cities\Exceptions\CityNotFoundException;
use App\Cities\Repositories\Interfaces\CityRepositoryInterface;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Jsdecena\MCPro\Models\City;

class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    public function __construct(City $city)
    {
        $this->model = $city;
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
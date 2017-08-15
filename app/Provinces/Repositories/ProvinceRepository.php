<?php

namespace App\Provinces\Repositories;

use App\Base\BaseRepository;
use App\Provinces\Exceptions\ProvinceNotFoundException;
use App\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Jsdecena\MCPro\Models\Province;

class ProvinceRepository extends BaseRepository implements ProvinceRepositoryInterface
{
    /**
     * ProvinceRepository constructor.
     * @param Province $province
     */
    public function __construct(Province $province)
    {
        $this->model = $province;
    }

    /**
     * List all the provinces
     *
     * @param string $order
     * @param string $sort
     * @return array
     */
    public function listProvinces(string $order = 'id', string $sort = 'desc') : array
    {
        $list = $this->model->orderBy($order, $sort)->get();

        return collect($list)->all();
    }

    /**
     * List all the cities
     *
     * @param Province $province
     * @return mixed
     */
    public function listCities(Province $province)
    {
        return $province->cities;
    }

    /**
     * Find the province
     *
     * @param int $id
     * @return Province
     */
    public function findProvinceById(int $id) : Province
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ProvinceNotFoundException($e->getMessage());
        }
    }

    /**
     * Update the province
     *
     * @param array $params
     * @return Province
     */
    public function updateProvince(array $params) : Province {
        try {
            $this->update($params, $this->model->id);
            return $this->findProvinceById($this->model->id);
        } catch (InvalidArgumentException $e) {
            throw new ProvinceNotFoundException($e->getMessage());
        }
    }
}
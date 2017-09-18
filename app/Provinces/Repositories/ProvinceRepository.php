<?php

namespace App\Provinces\Repositories;

use App\Base\BaseRepository;
use App\Provinces\Exceptions\ProvinceNotFoundException;
use App\Provinces\Province;
use App\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;

class ProvinceRepository extends BaseRepository implements ProvinceRepositoryInterface
{
    /**
     * ProvinceRepository constructor.
     * @param Province $province
     */
    public function __construct(Province $province)
    {
        parent::__construct($province);
    }

    /**
     * List all the provinces
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listProvinces(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort);
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
     * @return boolean
     */
    public function updateProvince(array $params) : bool
    {
        try {
            return $this->model->update($params);
        } catch (InvalidArgumentException $e) {
            throw new ProvinceNotFoundException($e->getMessage());
        }
    }

    /**
     * @param int $provinceId
     * @return mixed
     */
    public function listCities(int $provinceId)
    {
        return $this->findProvinceById($provinceId)->cities;
    }
}
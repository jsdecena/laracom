<?php

namespace App\Shop\Provinces\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Countries\Country;
use App\Shop\Provinces\Exceptions\ProvinceNotFoundException;
use App\Shop\Provinces\Province;
use App\Shop\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

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
        } catch (QueryException $e) {
            throw new ProvinceNotFoundException($e->getMessage());
        }
    }

    /**
     * @param int $provinceId
     * @return mixed
     */
    public function listCities(int $provinceId) : Collection
    {
        return $this->findProvinceById($provinceId)->cities()->get();
    }

    /**
     * @return Country
     */
    public function findCountry() : Country
    {
        return $this->model->country;
    }
}

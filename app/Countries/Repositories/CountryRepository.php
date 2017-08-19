<?php

namespace App\Countries\Repositories;

use App\Base\BaseRepository;
use App\Countries\Exceptions\CountryInvalidArgumentException;
use App\Countries\Exceptions\CountryNotFoundException;
use App\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Countries\Country;

class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{
    /**
     * CountryRepository constructor.
     * @param Country $country
     */
    public function __construct(Country $country)
    {
        parent::__construct($country);
        $this->model = $country;
    }

    /**
     * List all the countries
     *
     * @param string $order
     * @param string $sort
     * @return Collection
     */
    public function listCountries(string $order = 'id', string $sort = 'desc') : Collection
    {
        return $this->model->where('status', 1)->get();
    }

    /**
     * @param array $params
     * @return Country
     */
    public function createCountry(array $params) : Country
    {
        return $this->create($params);
    }

    /**
     * Find the country
     *
     * @param $id
     * @return Country
     * @throws CountryNotFoundException
     */
    public function findCountryById(int $id) : Country
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CountryNotFoundException($e->getMessage());
        }
    }

    /**
     * Show all the provinces
     *
     * @return mixed
     */
    public function findProvinces()
    {
        return $this->model->provinces;
    }

    /**
     * Update the country
     *
     * @param array $params
     * @return Country
     */
    public function updateCountry(array $params) : Country
    {
        try {
            $this->model->update($params);
            return $this->findCountryById($this->model->id);
        } catch (QueryException $e) {
            throw new CountryInvalidArgumentException($e->getMessage());
        }
    }
}
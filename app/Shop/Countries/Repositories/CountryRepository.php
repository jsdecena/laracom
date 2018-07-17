<?php

namespace App\Shop\Countries\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Countries\Exceptions\CountryInvalidArgumentException;
use App\Shop\Countries\Exceptions\CountryNotFoundException;
use App\Shop\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use App\Shop\Countries\Country;
use Illuminate\Support\Collection;

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
            throw new CountryNotFoundException('Country not found.');
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
     *
     * @return Country
     * @throws CountryNotFoundException
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

    /**
     *
     * @return Collection
     */
    public function listStates() : Collection
    {
        return $this->model->states()->get();
    }
}

<?php

namespace App\Countries\Repositories\Interfaces;

use App\Base\Interfaces\BaseRepositoryInterface;
use App\Countries\Country;
use Illuminate\Database\Eloquent\Collection;

interface CountryRepositoryInterface extends BaseRepositoryInterface
{
    public function updateCountry(array $params) : Country;

    public function listCountries(string $order = 'id', string $sort = 'desc') : Collection;

    public function createCountry(array $params) : Country;

    public function findCountryById(int $id) : Country;

    public function findProvinces();
}
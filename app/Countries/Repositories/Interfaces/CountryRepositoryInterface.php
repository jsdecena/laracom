<?php

namespace App\Countries\Repositories\Interfaces;

use App\Base\Interfaces\BaseRepositoryInterface;
use Jsdecena\MCPro\Models\Country;

interface CountryRepositoryInterface extends BaseRepositoryInterface
{
    public function updateCountry(array $params) : Country;

    public function listCountries(string $order = 'id', string $sort = 'desc') : array;

    public function createCountry(array $params) : Country;

    public function findCountryById(int $id) : Country;

    public function findProvinces();
}
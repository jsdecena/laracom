<?php

namespace App\Cities\Repositories\Interfaces;

use App\Base\Interfaces\BaseRepositoryInterface;
use App\Cities\City;

interface CityRepositoryInterface extends BaseRepositoryInterface
{
    public function listCities();

    public function findCityById(int $id) : City;

    public function updateCity(array $params) : City;
}
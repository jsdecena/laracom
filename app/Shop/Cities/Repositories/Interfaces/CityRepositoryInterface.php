<?php

namespace App\Shop\Cities\Repositories\Interfaces;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Cities\City;

interface CityRepositoryInterface extends BaseRepositoryInterface
{
    public function listCities();

    public function findCityById(int $id) : City;

    public function updateCity(array $params) : City;
}
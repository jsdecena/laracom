<?php

namespace App\Cities\Repositories\Interfaces;

use App\Base\Interfaces\BaseRepositoryInterface;
use Jsdecena\MCPro\Models\City;

interface CityRepositoryInterface extends BaseRepositoryInterface
{
    public function findCityById(int $id) : City;

    public function updateCity(array $params) : City;
}
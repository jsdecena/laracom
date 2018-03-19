<?php

namespace Laracommerce\Core\Cities\Repositories\Interfaces;

use Laracommerce\Core\Base\Interfaces\BaseRepositoryInterface;
use Laracommerce\Core\Cities\City;

interface CityRepositoryInterface extends BaseRepositoryInterface
{
    public function listCities();

    public function findCityById(int $id) : City;

    public function updateCity(array $params) : City;
}

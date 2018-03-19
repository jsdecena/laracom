<?php

namespace Laracommerce\Core\Provinces\Repositories\Interfaces;

use Laracommerce\Core\Base\Interfaces\BaseRepositoryInterface;
use Laracommerce\Core\Countries\Country;
use Laracommerce\Core\Provinces\Province;
use Illuminate\Support\Collection;

interface ProvinceRepositoryInterface extends BaseRepositoryInterface
{
    public function listProvinces(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection;

    public function findProvinceById(int $id) : Province;

    public function updateProvince(array $params) : bool;

    public function listCities(int $provinceId);

    public function findCountry() : Country;
}

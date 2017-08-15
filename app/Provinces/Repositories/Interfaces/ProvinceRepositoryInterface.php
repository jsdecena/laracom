<?php

namespace App\Provinces\Repositories\Interfaces;

use App\Base\Interfaces\BaseRepositoryInterface;
use App\Provinces\Province;
use Illuminate\Database\Eloquent\Collection;

interface ProvinceRepositoryInterface extends BaseRepositoryInterface
{
    public function listProvinces(string $order = 'id', string $sort = 'desc') : array;

    public function listCities() : Collection;

    public function findProvinceById(int $id) : Province;

    public function updateProvince(array $params) : Province;
}
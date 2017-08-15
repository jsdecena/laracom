<?php

namespace App\Provinces\Repositories\Interfaces;

use App\Base\Interfaces\BaseRepositoryInterface;
use Jsdecena\MCPro\Models\Province;

interface ProvinceRepositoryInterface extends BaseRepositoryInterface
{
    public function listProvinces(string $order = 'id', string $sort = 'desc') : array;

    public function listCities(Province $province);

    public function findProvinceById(int $id) : Province;

    public function updateProvince(array $params) : Province;
}
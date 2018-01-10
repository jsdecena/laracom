<?php

namespace App\Shop\Couriers\Repositories\Interfaces;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Couriers\Courier;
use Illuminate\Support\Collection;

interface CourierRepositoryInterface extends BaseRepositoryInterface
{
    public function createCourier(array $data) : Courier;

    public function updateCourier(array $params) : Courier;

    public function findCourierById(int $id) : Courier;

    public function listCouriers(string $order = 'id', string $sort = 'desc') : Collection;
}
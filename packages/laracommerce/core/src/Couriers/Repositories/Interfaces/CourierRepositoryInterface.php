<?php

namespace Laracommerce\Core\Couriers\Repositories\Interfaces;

use Laracommerce\Core\Base\Interfaces\BaseRepositoryInterface;
use Laracommerce\Core\Couriers\Courier;
use Illuminate\Support\Collection;

interface CourierRepositoryInterface extends BaseRepositoryInterface
{
    public function createCourier(array $data) : Courier;

    public function updateCourier(array $params) : Courier;

    public function findCourierById(int $id) : Courier;

    public function listCouriers(string $order = 'id', string $sort = 'desc') : Collection;
}

<?php

namespace App\Shop\States\Repositories;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface StateRepositoryInterface extends BaseRepositoryInterface
{
    public function listCities() : Collection;
}
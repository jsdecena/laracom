<?php

namespace Laracommerce\Core\Countries\Repositories\Interfaces;

use Laracommerce\Core\Base\Interfaces\BaseRepositoryInterface;
use Laracommerce\Core\Countries\Country;
use Illuminate\Database\Eloquent\Collection;

interface CountryRepositoryInterface extends BaseRepositoryInterface
{
    public function updateCountry(array $params) : Country;

    public function listCountries(string $order = 'id', string $sort = 'desc') : Collection;

    public function createCountry(array $params) : Country;

    public function findCountryById(int $id) : Country;

    public function findProvinces();
}

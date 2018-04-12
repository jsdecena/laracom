<?php

namespace App\Shop\Roles\Repositories;


use App\Shop\Roles\Role;
use Laracommerce\Core\Base\Interfaces\BaseRepositoryInterface;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function createRole(array $data) : Role;
}

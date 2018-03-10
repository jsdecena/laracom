<?php

namespace App\Shop\Roles\Repositories;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Roles\Role;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function createRole(array $data) : Role;
}
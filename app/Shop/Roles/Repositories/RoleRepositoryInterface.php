<?php

namespace App\Shop\Roles\Repositories;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Roles\Role;
use Illuminate\Support\Collection;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function createRole(array $data) : Role;

    public function listRoles(string $order = 'id', string $sort = 'desc') : Collection;
}

<?php

namespace Laracommerce\Core\Roles\Repositories;

use Laracommerce\Core\Base\Interfaces\BaseRepositoryInterface;
use Laracommerce\Core\Roles\Role;

interface RoleRepositoryInterface extends BaseRepositoryInterface
{
    public function createRole(array $data) : Role;
}

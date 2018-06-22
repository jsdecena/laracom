<?php

namespace App\Shop\Permissions\Repositories\Interfaces;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Permissions\Permission;
use Illuminate\Support\Collection;

interface PermissionRepositoryInterface extends BaseRepositoryInterface
{
    public function createPermission(array $data) : Permission;

    public function findPermissionById(int $id) : Permission;

    public function updatePermission(array $data, int $id) : bool;

    public function deletePermissionById(int $id) : bool;

    public function listPermissions() : Collection;
}
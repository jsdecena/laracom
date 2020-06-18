<?php

namespace App\Shop\Permissions\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Permissions\Exceptions\CreatePermissionErrorException;
use App\Shop\Permissions\Exceptions\DeletePermissionErrorException;
use App\Shop\Permissions\Exceptions\PermissionNotFoundErrorException;
use App\Shop\Permissions\Exceptions\UpdatePermissionErrorException;
use App\Shop\Permissions\Permission;
use App\Shop\Permissions\Repositories\Interfaces\PermissionRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    /**
     * PermissionRepository constructor.
     *
     * @param Permission $permission
     */
    public function __construct(Permission $permission)
    {
        parent::__construct($permission);
        $this->model = $permission;
    }

    /**
     * @param array $data
     *
     * @return Permission
     * @throws CreatePermissionErrorException
     */
    public function createPermission(array $data) : Permission
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreatePermissionErrorException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Permission
     * @throws PermissionNotFoundErrorException
     */
    public function findPermissionById(int $id) : Permission
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new PermissionNotFoundErrorException($e);
        }
    }

    /**
     * @param array $data
     *
     * @return bool
     * @throws UpdatePermissionErrorException
     */
    public function updatePermission(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new UpdatePermissionErrorException($e);
        }
    }

    /**
     * @return bool
     * @throws DeletePermissionErrorException
     */
    public function deletePermissionById() : bool
    {
        try {
            return $this->delete();
        } catch (QueryException $e) {
            throw new DeletePermissionErrorException($e);
        }
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return Collection
     */
    public function listPermissions($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }
}

<?php

namespace Laracommerce\Core\Employees\Repositories\Interfaces;

use Laracommerce\Core\Base\Interfaces\BaseRepositoryInterface;
use Laracommerce\Core\Employees\Employee;
use Illuminate\Support\Collection;

interface EmployeeRepositoryInterface extends BaseRepositoryInterface
{
    public function listEmployees(string $order = 'id', string $sort = 'desc') : array;

    public function createEmployee(array $params) : Employee;

    public function findEmployeeById(int $id) : Employee;

    public function updateEmployee(array $params) : bool;

    public function syncRoles(array $roleIds);

    public function listRoles() : Collection;

    public function hasRole(string $roleName) : bool;
}

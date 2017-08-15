<?php

namespace App\Employees\Repositories\Interfaces;

use App\Base\Interfaces\BaseRepositoryInterface;
use App\Employees\Employee;

interface EmployeeRepositoryInterface extends BaseRepositoryInterface
{
    public function listEmployees(string $order = 'id', string $sort = 'desc') : array;

    public function createEmployee(array $params) : Employee;

    public function findEmployeeById(int $id) : Employee;

    public function updateEmployee(array $params) : bool;
}
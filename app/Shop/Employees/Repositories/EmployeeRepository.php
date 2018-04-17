<?php

namespace App\Shop\Employees\Repositories;

use App\Shop\Base\BaseRepository;
use App\Shop\Employees\Employee;
use App\Shop\Employees\Exceptions\EmployeeNotFoundException;
use App\Shop\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    /**
     * EmployeeRepository constructor.
     * @param Employee $employee
     */
    public function __construct(Employee $employee)
    {
        parent::__construct($employee);
        $this->model = $employee;
    }

    /**
     * List all the employees
     *
     * @param string $order
     * @param string $sort
     * @return array
     */
    public function listEmployees(string $order = 'id', string $sort = 'desc'): Collection
    {
        return $this->all(['*'], $order, $sort);
    }

    /**
     * Create the employee
     *
     * @param array $params
     * @return Employee
     */
    public function createEmployee(array $params): Employee
    {
        $collection = collect($params);

        $employee = new Employee(($collection->except('password'))->all());
        $employee->password = bcrypt($collection->only('password'));
        $employee->save();

        return $employee;
    }

    /**
     * Find the employee by id
     *
     * @param int $id
     * @return Employee
     */
    public function findEmployeeById(int $id): Employee
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new EmployeeNotFoundException;
        }
    }

    /**
     * Update employee
     *
     * @param array $params
     * @return bool
     */
    public function updateEmployee(array $params): bool
    {
        return $this->model->update($params);
    }

    /**
     * @param array $roleIds
     */
    public function syncRoles(array $roleIds)
    {
        $this->model->roles()->sync($roleIds);
    }

    /**
     * @return Collection
     */
    public function listRoles(): Collection
    {
        return $this->model->roles()->get();
    }

    /**
     * @param string $roleName
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->model->hasRole($roleName);
    }
}

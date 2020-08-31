<?php

namespace App\Shop\Employees\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Employees\Employee;
use App\Shop\Employees\Exceptions\EmployeeNotFoundException;
use App\Shop\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    /**
     * EmployeeRepository constructor.
     *
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
     *
     * @return Collection
     */
    public function listEmployees(string $order = 'id', string $sort = 'desc'): Collection
    {
        return $this->all(['*'], $order, $sort);
    }

    /**
     * Create the employee
     *
     * @param array $data
     *
     * @return Employee
     */
    public function createEmployee(array $data): Employee
    {
        $data['password'] = Hash::make($data['password']);
        return $this->create($data);
    }

    /**
     * Find the employee by id
     *
     * @param int $id
     *
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
     *
     * @return bool
     */
    public function updateEmployee(array $params): bool
    {
        if (isset($params['password'])) {
            $params['password'] = Hash::make($params['password']);
        }

        return $this->update($params);
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
     *
     * @return bool
     */
    public function hasRole(string $roleName): bool
    {
        return $this->model->hasRole($roleName);
    }

    /**
     * @param Employee $employee
     *
     * @return bool
     */
    public function isAuthUser(Employee $employee): bool
    {
        $isAuthUser = false;
        if (Auth::guard('employee')->user()->id == $employee->id) {
            $isAuthUser = true;
        }
        return $isAuthUser;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteEmployee() : bool
    {
        return $this->delete();
    }
}

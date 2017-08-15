<?php

namespace App\Employees\Repositories;

use App\Base\BaseRepository;
use App\Employees\Employee;
use App\Employees\Exceptions\EmployeeNotFoundException;
use App\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeRepository extends BaseRepository implements EmployeeRepositoryInterface
{
    public function __construct(Employee $employee)
    {
        $this->model = $employee;
    }

    /**
     * List all the employees
     *
     * @param string $order
     * @param string $sort
     * @return array
     */
    public function listEmployees(string $order = 'id', string $sort = 'desc') : array
    {
        $list = $this->model->orderBy($order, $sort)->get();

        return collect($list)->all();
    }

    /**
     * Create the employee
     *
     * @param array $params
     * @return Employee
     */
    public function createEmployee(array $params) : Employee
    {
        $collection = collect($params);

        $employee = new Employee(($collection->except('password'))->toArray());
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
    public function findEmployeeById(int $id) : Employee
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
    public function updateEmployee(array $params) : bool
    {
        $collection = collect($params)->except('password');

        if (in_array('password', $params)) {
            $this->model->password = $params['password'];
        }

        $this->update($collection->all(), $this->model->id);

        return $this->model->save();
    }
}
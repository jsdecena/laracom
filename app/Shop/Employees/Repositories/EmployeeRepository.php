<?php

namespace App\Shop\Employees\Repositories;

use App\Shop\Base\BaseRepository;
use App\Shop\Employees\Employee;
use App\Shop\Employees\Exceptions\EmployeeNotFoundException;
use App\Shop\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
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
        $fields = [
            "name" => $params['name'],
            "email" => $params['email']
        ];

        if (isset($params['password']) && !is_null($params['password'])) {
            $fields = [
                "name" => $params['name'],
                "email" => $params['email'],
                "password" => bcrypt($params['password'])
            ];
        }

        return $this->model->update($fields);
    }
}

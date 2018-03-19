<?php

use Laracommerce\Core\Employees\Employee;
use Laracommerce\Core\Roles\Role;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    public function run()
    {
        factory(Employee::class)->create()->each(function (Employee $employee) {
            factory(Role::class)->create(['name' => 'admin'])->each(function(Role $role) use ($employee) {
                $employee->roles()->save($role);
            });
        });

        factory(Employee::class)->create();
    }
}
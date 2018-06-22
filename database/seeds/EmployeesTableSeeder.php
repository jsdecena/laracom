<?php

use App\Shop\Employees\Employee;
use App\Shop\Roles\Role;
use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{
    public function run()
    {
        $employee = factory(Employee::class)->create([
            'email' => 'john@doe.com'
        ]);

        $super = factory(Role::class)->create([
            'name' => 'superadmin',
            'display_name' => 'Super Admin'
        ]);

        $employee->roles()->save($super);

        $employee = factory(Employee::class)->create([
            'email' => 'admin@doe.com'
        ]);

        $admin = factory(Role::class)->create([
            'name' => 'admin',
            'display_name' => 'Admin'
        ]);

        $employee->roles()->save($admin);

        $employee = factory(Employee::class)->create([
            'email' => 'clerk@doe.com'
        ]);

        $clerk = factory(Role::class)->create([
            'name' => 'clerk',
            'display_name' => 'Clerk'
        ]);

        $employee->roles()->save($clerk);
    }
}

<?php

namespace Tests\Unit\Employees;

use App\Shop\Employees\Employee;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Shop\Roles\Repositories\RoleRepository;
use App\Shop\Roles\Role;
use Tests\TestCase;

class EmployeeUnitTest extends TestCase
{
    /** @test */
    public function it_can_list_all_the_roles_associated_to_the_employee()
    {
        $employee = factory(Employee::class)->create();

        $roleRepo = new RoleRepository(new Role);
        $userRole = $roleRepo->createRole(['name' => 'user']);

        $employeeRepo = new EmployeeRepository($employee);
        $employeeRepo->syncRoles([$userRole->id]);

        $employeeRoles = $employeeRepo->listRoles();

        $this->assertCount(1, $employeeRoles->all());

        $employeeRoles->each(function (Role $role) use ($userRole) {
            $this->assertEquals($userRole->name, $role->name);
        });
    }
    /** @test */
    public function it_can_attach_or_detach_the_employee_role()
    {
        $employee = factory(Employee::class)->create();
        $role = factory(Role::class)->create();

        $employee->roles()->attach($role);
        $this->assertTrue($employee->hasRole($role->name));

        $employee->roles()->detach($role);
        $this->assertFalse($employee->hasRole($role->name));
    }
}

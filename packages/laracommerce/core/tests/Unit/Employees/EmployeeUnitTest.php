<?php

namespace Laracommerce\Core\Tests\Unit\Employees;

use Laracommerce\Core\Employees\Employee;
use Laracommerce\Core\Employees\Repositories\EmployeeRepository;
use Laracommerce\Core\Roles\Repositories\RoleRepository;
use Laracommerce\Core\Roles\Role;
use Laracommerce\Core\Tests\TestCase;

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
}

<?php

namespace Tests\Feature;

use App\Shop\Employees\Employee;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Shop\Roles\Repositories\RoleRepository;
use App\Shop\Roles\Role;
use Tests\TestCase;

class CreateProductPageTest extends TestCase
{
    /** @test */
    public function it_should_not_show_to_customers()
    {
        $this
            ->actingAs($this->customer, 'web')
            ->get(route('admin.products.create'))
            ->assertStatus(302)
            ->assertSessionHas(['error' => 'You must be an employee to see this page']);
    }

    /** @test */
    public function it_should_show_to_admin_role()
    {
        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.products.create'))
            ->assertStatus(200);
    }

    /** @test */
    public function it_should_not_show_to_non_admin_role()
    {
        $employee = factory(Employee::class)->create();

        $roleRepo = new RoleRepository(new Role);
        $admin = $roleRepo->createRole(['name' => 'user']);

        $employeeRepo = new EmployeeRepository($employee);
        $employeeRepo->syncRoles([$admin->id]);

        $this
            ->actingAs($employee, 'employee')
            ->get(route('admin.products.create'))
            ->assertStatus(403)
            ->assertSee('Sorry, this page is restricted to authorized users only.');
    }

    /** @test */
    public function it_should_not_show_to_employees_without_any_role()
    {
        $employee = factory(Employee::class)->create();

        $this
            ->actingAs($employee, 'employee')
            ->get(route('admin.products.create'))
            ->assertStatus(403)
            ->assertSee('Sorry, this page is restricted to authorized users only.');
    }
}

<?php

namespace Tests\Feature\Admin\Dashboard;

use App\Shop\Employees\Employee;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Shop\Roles\Role;
use Tests\TestCase;

class DashboardFeatureTest extends TestCase
{
    /** @test */
    public function it_should_show_the_admin_abilities_when_the_employee_is_admin()
    {
        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.dashboard'))
            ->assertStatus(200)
            ->assertSee('Home')
            ->assertSee('List products')
            ->assertSee('Create product')
            ->assertSee('List categories')
            ->assertSee('Create category')
            ->assertSee('List brands')
            ->assertSee('Create brand');
    }

    /** @test */
    public function it_should_not_show_admin_abilities_when_the_employee_is_not_admin()
    {
        $employee = factory(Employee::class)->create();
        $role = factory(Role::class)->create(['name' => 'clerk']);

        $employeeRepo = new EmployeeRepository($employee);
        $employeeRepo->syncRoles([$role->id]);

        $this
            ->actingAs($employee, 'employee')
            ->get(route('admin.dashboard'))
            ->assertStatus(200)
            ->assertSee('Home');
    }
}

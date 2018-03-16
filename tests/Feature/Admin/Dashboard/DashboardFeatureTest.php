<?php

namespace Tests\Feature\Admin\Dashboard;

use App\Shop\Employees\Employee;
use Tests\TestCase;

class DashboardFeatureTest extends TestCase
{
    /** @test */
    public function it_should_show_the_admin_abilities_when_the_employee_is_admin()
    {
        $this
            ->actingAs($this->employee, 'admin')
            ->get(route('admin.dashboard'))
            ->assertStatus(200)
            ->assertSee('Dashboard')
            ->assertSee('List products')
            ->assertSee('Create product')
            ->assertSee('List categories')
            ->assertSee('Create category');
    }

    /** @test */
    public function it_should_not_show_admin_abilities_when_the_employee_is_not_admin()
    {
        $employee = factory(Employee::class)->create();

        $this
            ->actingAs($employee, 'admin')
            ->get(route('admin.dashboard'))
            ->assertStatus(200)
            ->assertSee('Dashboard')
            ->assertDontSee('List products')
            ->assertDontSee('Create product')
            ->assertDontSee('List categories')
            ->assertDontSee('Create category');
    }
}

<?php

namespace Tests\Feature\Admin\Roles;

use App\Shop\Roles\Role;
use Tests\TestCase;

class RoleFeatureTest extends TestCase
{
    /** @test */
    public function it_can_see_the_list_of_roles()
    {
        $this->actingAs($this->employee, 'employee')
            ->get(route('admin.roles.index'))
            ->assertSee('Name')
            ->assertSee('Display Name')
            ->assertSee('Description')
            ->assertSee($this->role->name)
            ->assertStatus(200);
    }

    /** @test */
    public function it_can_edit_the_role()
    {
        $role = factory(Role::class)->create();

        $data = [
            'name' => 'superadministrator',
            'display_name' => 'Super Administrator',
            'description' => 'Super administrator user'
        ];

        $this->actingAs($this->employee, 'employee')
            ->put(route('admin.roles.update', $role->id), $data)
            ->assertSessionHas('message', 'Update role successful!')
            ->assertStatus(302)
            ->assertRedirect(route('admin.roles.edit', $role->id));
    }

    /** @test */
    public function it_can_show_the_edit_role_page()
    {
        $data = [
            'name' => 'superadmin',
            'description' => 'Super admin user'
        ];

        $role = factory(Role::class)->create($data);

        $this->actingAs($this->employee, 'employee')
            ->get(route('admin.roles.edit', $role->id))
            ->assertSee('Display name')
            ->assertSee($role->display_name)
            ->assertSee('Description')
            ->assertSee($role->description)
            ->assertStatus(200);
    }

    /** @test */
    public function it_can_create_the_role()
    {
        $data = [
            'name' => 'superadmin',
            'display_name' => 'Super Admin',
            'description' => 'Super admin user'
        ];

        $this->actingAs($this->employee, 'employee')
            ->post(route('admin.roles.store'), $data)
            ->assertSessionHas('message', 'Create role successful!')
            ->assertStatus(302)
            ->assertRedirect(route('admin.roles.index'));
    }

    /** @test */
    public function it_can_show_the_create_role_form()
    {
        $this->actingAs($this->employee, 'employee')
            ->get(route('admin.roles.create'))
            ->assertSee('Name')
            ->assertSee('Display name')
            ->assertSee('Description')
            ->assertStatus(200);
    }
}

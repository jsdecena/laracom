<?php

namespace Tests\Unit\Roles;

use App\Shop\Roles\Exceptions\CreateRoleErrorException;
use App\Shop\Roles\Repositories\RoleRepository;
use App\Shop\Roles\Role;
use Illuminate\Support\Collection;
use Tests\TestCase;

class RoleUnitTest extends TestCase
{
    /** @test */
    public function it_can_list_all_roles()
    {
        factory(Role::class, 5)->create();

        $roleRepo = new RoleRepository(new Role);
        $roles = $roleRepo->listRoles();

        $this->assertInstanceOf(Collection::class, $roles);
        $this->assertCount(6, $roles->all()); // +1 in the TestCase
    }

    /** @test */
    public function it_can_delete_the_role()
    {
        $role = factory(Role::class)->create();

        $roleRepo = new RoleRepository($role);
        $deleted = $roleRepo->deleteRoleById();

        $this->assertTrue($deleted);
    }

    /** @test */
    public function it_can_update_the_role()
    {
        $role = factory(Role::class)->create();

        $data = [
            'name' => 'user',
            'display_name' => 'Website user'
        ];

        $roleRepo = new RoleRepository($role);
        $updated = $roleRepo->updateRole($data);

        $role = $roleRepo->findRoleById($role->id);

        $this->assertTrue($updated);
        $this->assertEquals($data['name'], $role->name);
        $this->assertEquals($data['display_name'], $role->display_name);
    }
    
    /** @test */
    public function it_can_return_the_created_role()
    {
        $roleFactory = factory(Role::class)->create();

        $roleRepo = new RoleRepository(new Role);
        $role = $roleRepo->findRoleById($roleFactory->id);

        $this->assertInstanceOf(Role::class, $role);
        $this->assertEquals($roleFactory->name, $role->name);
        $this->assertEquals($roleFactory->display_name, $role->display_name);
    }
    
    /** @test */
    public function it_can_create_a_role()
    {
        $data = [
            'name' => 'user',
            'display_name' => 'Website user'
        ];

        $roleRepo = new RoleRepository(new Role);
        $role = $roleRepo->createRole($data);

        $this->assertInstanceOf(Role::class, $role);
        $this->assertEquals($data['name'], $role->name);
        $this->assertEquals($data['display_name'], $role->display_name);
    }
    
    /** @test */
    public function it_errors_creating_the_role()
    {
        $this->expectException(CreateRoleErrorException::class);

        $roleRepo = new RoleRepository(new Role());
        $roleRepo->createRole([]);
    }
}

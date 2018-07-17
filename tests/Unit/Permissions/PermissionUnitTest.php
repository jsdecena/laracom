<?php

namespace Tests\Unit\Permissions;

use App\Shop\Permissions\Permission;
use App\Shop\Permissions\Repositories\PermissionRepository;
use App\Shop\Roles\Repositories\RoleRepository;
use App\Shop\Roles\Role;
use Illuminate\Support\Collection;
use Tests\TestCase;

class PermissionUnitTest extends TestCase
{
    /** @test */
    public function it_can_attach_permission_to_role()
    {
        $role = factory(Role::class)->create();
        $permission = factory(Permission::class)->create();

        $roleRepo = new RoleRepository($role);
        $roleRepo->attachToPermission($permission);
        $attachedPermissions =  $roleRepo->listPermissions();

        $attachedPermissions->each(function (Permission $item) use ($permission) {
            $this->assertEquals($permission->name, $item->name);
        });
    }

    /** @test */
    public function it_can_list_all_permissions()
    {
        factory(Permission::class, 5)->create();

        $permissionRepo = new PermissionRepository(new Permission);
        $list = $permissionRepo->listPermissions();

        $this->assertInstanceOf(Collection::class, $list);
        $this->assertCount(9, $list->all());
    }

    /** @test */
    public function it_can_delete_permission()
    {
        $permission = factory(Permission::class)->create();

        $permissionRepo = new PermissionRepository($permission);
        $deleted = $permissionRepo->deletePermissionById($permission->id);

        $this->assertTrue($deleted);
    }

    /** @test */
    public function it_can_update_the_permission()
    {
        $permission = factory(Permission::class)->create();

        $data = [
            'name' => 'can-view',
            'display_name' => 'Can View'
        ];

        $permissionRepo = new PermissionRepository($permission);
        $updated = $permissionRepo->updatePermission($data);

        $found = $permissionRepo->findPermissionById($permission->id);

        $this->assertTrue($updated);
        $this->assertEquals($data['name'], $found->name);
        $this->assertEquals($data['display_name'], $found->display_name);
    }

    /** @test */
    public function it_can_show_the_permission()
    {
        $permission = factory(Permission::class)->create();

        $permissionRepo = new PermissionRepository(new Permission);
        $found = $permissionRepo->findPermissionById($permission->id);

        $this->assertInstanceOf(Permission::class, $found);
        $this->assertEquals($permission->name, $found->name);
        $this->assertEquals($permission->display_name, $found->display_name);
    }

    /** @test */
    public function it_can_create_permission()
    {
        $data = [
            'name' => 'can-view-employee-list',
            'display_name' => 'Can View',
            'description' => 'can view permission'
        ];

        $permissionRepo = new PermissionRepository(new Permission);
        $permission = $permissionRepo->createPermission($data);

        $this->assertInstanceOf(Permission::class, $permission);
        $this->assertEquals($data['name'], $permission->name);
        $this->assertEquals($data['display_name'], $permission->display_name);
        $this->assertEquals($data['description'], $permission->description);
    }
}

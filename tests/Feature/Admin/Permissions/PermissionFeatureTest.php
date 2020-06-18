<?php

namespace Tests\Feature\Admin\Permissions;

use App\Shop\Permissions\Permission;
use Tests\TestCase;

class PermissionFeatureTest extends TestCase
{
    /** @test */
    public function it_can_display_all_the_permissions()
    {
        $permission = factory(Permission::class)->create();

        $this->actingAs($this->employee, 'employee')
            ->get(route('admin.permissions.index'))
            ->assertSee($permission->display_name)
            ->assertStatus(200);
    }
}

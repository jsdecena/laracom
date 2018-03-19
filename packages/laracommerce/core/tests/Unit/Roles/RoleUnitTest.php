<?php

namespace Laracommerce\Core\Tests\Unit\Roles;

use Laracommerce\Core\Roles\Exceptions\CreateRoleErrorException;
use Laracommerce\Core\Roles\Repositories\RoleRepository;
use Laracommerce\Core\Roles\Role;
use Laracommerce\Core\Tests\TestCase;

class RoleUnitTest extends TestCase
{
    /** @test */
    public function it_errors_creating_the_role()
    {
        $this->expectException(CreateRoleErrorException::class);

        $roleRepo = new RoleRepository(new Role());
        $roleRepo->createRole([]);
    }
}

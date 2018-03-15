<?php

namespace Tests\Unit\Roles;

use App\Shop\Roles\Exceptions\CreateRoleErrorException;
use App\Shop\Roles\Repositories\RoleRepository;
use App\Shop\Roles\Role;
use Tests\TestCase;

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

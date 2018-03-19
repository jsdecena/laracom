<?php

namespace Laracommerce\Core\Roles;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    protected $fillable = [
        'name',
        'display_name'
    ];
}

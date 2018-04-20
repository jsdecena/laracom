<?php

namespace App\Shop\Roles;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    protected $table = 'ecom_roles';

    protected $fillable = [
        'name',
        'display_name'
    ];
}

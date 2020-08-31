<?php

namespace App\Shop\Roles;

use Laratrust\Models\LaratrustRole;

class Role extends LaratrustRole
{
    protected $fillable = [
        'name',
        'display_name',
        'description'
    ];
}

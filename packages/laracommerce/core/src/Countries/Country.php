<?php

namespace Laracommerce\Core\Countries;

use Laracommerce\Core\Provinces\Province;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'iso',
        'iso3',
        'numcode',
        'phonecode',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function provinces()
    {
        return $this->hasMany(Province::class);
    }
}

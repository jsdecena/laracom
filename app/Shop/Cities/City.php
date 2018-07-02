<?php

namespace App\Shop\Cities;

use App\Shop\Provinces\Province;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'province_id'
    ];

    public $timestamps = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }
}

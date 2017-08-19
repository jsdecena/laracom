<?php

namespace App\Provinces;

use App\Cities\City;
use App\Countries\Country;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'country_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function country()
    {
    	return $this->belongsTo(Country::class);
    }

    public function cities()
    {
    	return $this->hasMany(City::class);
    }    
}

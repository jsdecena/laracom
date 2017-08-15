<?php

namespace App\Provinces;

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
    	return $this->belongsTo('App\Countries\Country');
    }

    public function cities()
    {
    	return $this->hasMany('App\Cities\City');
    }    
}

<?php

namespace App\Shop\Addresses;

use App\Shop\Customers\Customer;
use App\Shop\Orders\Order;
use App\Shop\Provinces\Province;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Shop\Cities\City;
use App\Shop\Countries\Country;
use Nicolaslopezj\Searchable\SearchableTrait;

class Address extends Model
{
    use SoftDeletes, SearchableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'alias',
        'address_1',
        'address_2',
        'zip',
        'city',
        'state_code',
        'province_id',
        'country_id',
        'customer_id',
        'status',
        'phone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates = ['deleted_at'];

    /**
     * Searchable rules.
     *
     * @var array
     */
    protected $searchable = [
        'columns' => [
            'alias' => 5,
            'address_1' => 10,
            'address_2' => 5,
            'zip' => 5,
            'city' => 10,
            'state_code' => 10,
            'phone' => 5
        ]
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    /**
     * @deprecated
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * @param $term
     *
     * @return mixed
     */
    public function searchAddress($term)
    {
        return self::search($term);
    }
}

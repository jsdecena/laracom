<?php

namespace App\Shop\PaymentMethods;

use App\Shop\Orders\Order;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
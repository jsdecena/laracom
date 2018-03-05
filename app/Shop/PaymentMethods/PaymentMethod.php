<?php

namespace App\Shop\PaymentMethods;

use App\Shop\Orders\Order;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentMethod
 * @package App\Shop\PaymentMethods
 */
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
        'account_id',
        'client_id',
        'client_secret',
        'api_url',
        'redirect_url',
        'cancel_url',
        'failed_url',
        'mode',
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

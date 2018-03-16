<?php

namespace App\Shop\Orders;

use App\Shop\Addresses\Address;
use App\Shop\Couriers\Courier;
use App\Shop\Customers\Customer;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\Products\Product;
use Illuminate\Database\Eloquent\Model;
use Sofa\Eloquence\Eloquence;

class Order extends Model
{
    use Eloquence;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reference',
        'courier_id',
        'customer_id',
        'address_id',
        'order_status_id',
        'payment',
        'discounts',
        'total_products',
        'total',
        'tax',
        'total_paid',
        'invoice',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function products()
    {
        return $this->belongsToMany(Product::class)
                    ->withPivot(['quantity']);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function courier()
    {
        return $this->belongsTo(Courier::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class);
    }
}

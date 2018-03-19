<?php

namespace Laracommerce\Core\Orders;

use Laracommerce\Core\Addresses\Address;
use Laracommerce\Core\Couriers\Courier;
use Laracommerce\Core\Customers\Customer;
use Laracommerce\Core\OrderStatuses\OrderStatus;
use Laracommerce\Core\Products\Product;
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

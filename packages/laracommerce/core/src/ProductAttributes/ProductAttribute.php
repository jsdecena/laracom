<?php

namespace Laracommerce\Core\ProductAttributes;

use Laracommerce\Core\AttributeValues\AttributeValue;
use Laracommerce\Core\Products\Product;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $fillable = [
        'quantity',
        'price'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributesValues()
    {
        return $this->belongsToMany(AttributeValue::class);
    }
}

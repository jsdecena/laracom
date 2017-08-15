<?php

namespace App\Tools;

use App\Products\Product;

trait CurrencyTransformable
{
    /**
     * Transform the currency
     *
     * @param Product $product
     * @return Product
     */
    protected function transformCurrency(Product $product)
    {
        $prop = new Product;
        $prop->id = (int) $product->id;
        $prop->name = $product->name;
        $prop->sku = $product->sku;
        $prop->slug = $product->slug;
        $prop->description = $product->description;
        $prop->cover = $product->cover;
        $prop->quantity = $product->quantity;
        $prop->price = (float) $product->price;
        $prop->status = $product->status;

        return $prop;
    }
}
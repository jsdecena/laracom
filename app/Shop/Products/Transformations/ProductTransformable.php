<?php

namespace App\Shop\Products\Transformations;

use App\Shop\Products\Product;

trait ProductTransformable
{
    /**
     * Transform the product
     *
     * @param Product $product
     * @return Product
     */
    protected function transformProduct(Product $product)
    {
        $prop = new Product;
        $prop->id = (int) $product->id;
        $prop->name = $product->name;
        $prop->sku = $product->sku;
        $prop->slug = $product->slug;
        $prop->description = $product->description;
        $prop->cover = $product->cover;
        $prop->quantity = $product->quantity;
        $prop->price = $product->price;
        $prop->status = $product->status;

        return $prop;
    }
}
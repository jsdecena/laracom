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
        $prod = new Product;
        $prod->id = (int) $product->id;
        $prod->name = $product->name;
        $prod->sku = $product->sku;
        $prod->slug = $product->slug;
        $prod->description = $product->description;
        $prod->cover = $this->rewriteExitsImagePath($product->cover);
        $prod->quantity = $product->quantity;
        $prod->price = $product->price;
        $prod->status = $product->status;
        $prod->weight = (float) $product->weight;
        $prod->mass_unit = $product->mass_unit;
        $prod->sale_price = $product->sale_price;
        $prod->brand_id = (int) $product->brand_id;

        return $prod;
    }

    /**
     * it checks the image path which registered to DB and it exists whether on storage. 
     * if exist, return original path add asset. 
     * if not exist, return path for No Data.png
     * 
     * @param string $path
     * @return string $existsPath
     */
    private function rewriteExitsImagePath($path)
    {
        if ($path == null) {
            return $path;
        }
        if (file_exists("/var/www/storage/app/public/" . $path)) {
            return asset("storage/$path");
        }
        return asset("images/NoData.png");
    }
}

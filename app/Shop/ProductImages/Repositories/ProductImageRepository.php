<?php

namespace App\Shop\ProductImages\Repositories;

use App\Shop\ProductImages\ProductImage;

class ProductImageRepository
{
    /**
     * @var ProductImage
     */
    protected $model;

    /**
     * ProductImageRepository constructor.
     * @param ProductImage $productImage
     */
    public function __construct(ProductImage $productImage)
    {
        $this->model = $productImage;
    }
}
<?php

namespace App\Shop\ProductAttributes\Repositories;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\ProductAttributes\ProductAttribute;

interface ProductAttributeRepositoryInterface extends BaseRepositoryInterface
{
    public function createProductAttribute(array $data) : ProductAttribute;

    public function removeProductAttribute() : ?bool;
}
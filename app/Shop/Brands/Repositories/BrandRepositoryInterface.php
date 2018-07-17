<?php

namespace App\Shop\Brands\Repositories;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Brands\Brand;
use App\Shop\Products\Product;
use Illuminate\Support\Collection;

interface BrandRepositoryInterface extends BaseRepositoryInterface
{
    public function createBrand(array $data): Brand;

    public function findBrandById(int $id) : Brand;

    public function updateBrand(array $data, int $id) : bool;

    public function deleteBrand(int $id) : bool;

    public function listBrands($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection;

    public function saveProduct(Product $product);
}

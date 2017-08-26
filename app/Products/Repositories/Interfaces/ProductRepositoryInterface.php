<?php

namespace App\Products\Repositories\Interfaces;

use App\Base\Interfaces\BaseRepositoryInterface;
use App\Products\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function createProduct(array $data) : Product;

    public function updateProduct(array $update) : Product;

    public function findProductById(int $id) : Product;

    public function listProducts(string $order = 'id', bool $desc = false) : array;

    public function deleteProduct(Product $product) : bool;

    public function detachCategories(Product $product);

    public function getCategories() : Collection;

    public function syncCategories(array $params);

    public function deleteFile(array $file, $disk = null) : bool;

    public function findProductBySlug(array $slug) : Product;

    public function uploadOneImage($image, $folder = 'products');
}
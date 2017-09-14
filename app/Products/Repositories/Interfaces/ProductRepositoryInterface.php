<?php

namespace App\Products\Repositories\Interfaces;

use App\Base\Interfaces\BaseRepositoryInterface;
use App\Products\Product;
use Illuminate\Database\Eloquent\Collection;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function listProducts(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection;

    public function createProduct(array $data) : Product;

    public function updateProduct(array $params, int $id) : bool;

    public function findProductById(int $id) : Product;

    public function deleteProduct(Product $product) : bool;

    public function detachCategories(Product $product);

    public function getCategories() : Collection;

    public function syncCategories(array $params);

    public function deleteFile(array $file, $disk = null) : bool;

    public function findProductBySlug(array $slug) : Product;

    public function uploadOneImage($image, $folder = 'products');

    public function searchProduct(string $text) : Collection;
}
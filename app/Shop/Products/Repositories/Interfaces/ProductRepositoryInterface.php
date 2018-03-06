<?php

namespace App\Shop\Products\Repositories\Interfaces;

use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use App\Shop\Products\Product;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;

interface ProductRepositoryInterface extends BaseRepositoryInterface
{
    public function listProducts(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection;

    public function createProduct(array $data) : Product;

    public function updateProduct(array $params, int $id) : bool;

    public function findProductById(int $id) : Product;

    public function deleteProduct(Product $product) : bool;

    public function detachCategories();

    public function getCategories() : Collection;

    public function syncCategories(array $params);

    public function deleteFile(array $file, $disk = null) : bool;

    public function deleteThumb(string $src) : bool;

    public function findProductBySlug(array $slug) : Product;

    public function searchProduct(string $text) : Collection;

    public function findProductImages() : Collection;

    public function saveCoverImage(UploadedFile $file) : string;

    public function saveProductImages(Collection $collection, Product $product);
}

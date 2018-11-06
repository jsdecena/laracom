<?php

namespace App\Shop\Categories\Repositories\Interfaces;

use Jsdecena\Baserepo\BaseRepositoryInterface;
use App\Shop\Categories\Category;
use App\Shop\Products\Product;
use Illuminate\Support\Collection;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function listCategories(string $order = 'id', string $sort = 'desc', $except = []) : Collection;

    public function createCategory(array $params) : Category;

    public function updateCategory(array $params) : Category;

    public function findCategoryById(int $id) : Category;

    public function deleteCategory() : bool;

    public function associateProduct(Product $product);

    public function findProducts() : Collection;

    public function syncProducts(array $params);

    public function detachProducts();

    public function deleteFile(array $file, $disk = null) : bool;

    public function findCategoryBySlug(array $slug) : Category;

    public function rootCategories(string $string, string $string1);
}

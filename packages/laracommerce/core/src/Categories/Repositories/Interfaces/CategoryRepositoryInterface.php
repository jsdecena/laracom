<?php

namespace Laracommerce\Core\Categories\Repositories\Interfaces;

use Laracommerce\Core\Base\Interfaces\BaseRepositoryInterface;
use Laracommerce\Core\Categories\Category;
use Laracommerce\Core\Products\Product;
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
}

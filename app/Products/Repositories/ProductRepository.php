<?php

namespace App\Products\Repositories;

use App\Base\BaseRepository;
use App\Products\Exceptions\ProductInvalidArgumentException;
use App\Products\Exceptions\ProductNotFoundException;
use App\Products\Product;
use App\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Products\Transformations\ProductTransformable;
use App\Tools\UploadableTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    use UploadableTrait, ProductTransformable;

    /**
     * ProductRepository constructor.
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        parent::__construct($product);
    }

    /**
     * List all the products
     *
     * @param string $order
     * @param bool $desc
     * @return array
     */
    public function listProducts(string $order = 'id', bool $desc = false) : array
    {
        $list = $this->all();

        return collect($list)
            ->sortBy($order, SORT_REGULAR, $desc)
            ->map(function (Product $product) {
            return $this->transformProduct($product);
        })->all();
    }

    /**
     * Create the product
     *
     * @param array $params
     * @return Product
     */
    public function createProduct(array $params) : Product
    {
        try {

            $collection = collect($params)->except('_token');
            $slug = str_slug($collection->get('name'));


            if (request()->hasFile('cover')) {
                $file = request()->file('cover');
                $cover = $this->uploadOneImage($file);
            }

            $merge = $collection->merge(compact('slug', 'cover'));

            $product = new Product($merge->all());
            $product->save();
            return $product;

        } catch (QueryException $e) {
            throw new ProductInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Update the product
     *
     * @param array $params
     * @return bool
     */
    public function updateProduct(array $params) : bool
    {
        try {

            $collection = collect($params)->except('_token');
            $slug = str_slug($collection->get('name'));

            if (request()->hasFile('cover')) {
                $file = request()->file('cover');
                $cover = $this->uploadOneImage($file);
            }

            $merge = $collection->merge(compact('slug', 'cover'));
            return $this->model->update($merge->all());
        } catch (QueryException $e) {
            throw new ProductInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Find the product by ID
     *
     * @param int $id
     * @return Product
     */
    public function findProductById(int $id) : Product
    {
        try {

            return $this->transformProduct($this->findOneOrFail($id));
        } catch (ModelNotFoundException $e) {
            throw new ProductNotFoundException($e->getMessage());
        }
    }

    /**
     * Delete the product
     *
     * @param Product $product
     * @return bool
     */
    public function deleteProduct(Product $product) : bool
    {
        return $product->delete();
    }

    /**
     * Detach the categories
     *
     * @param Product $product
     */
    public function detachCategories(Product $product)
    {
        $product->categories()->detach();
    }

    /**
     * Return the categories which the product is associated with
     *
     * @return Collection
     */
    public function getCategories() : Collection
    {
        return $this->model->categories()->get();
    }

    /**
     * Sync the categories
     *
     * @param array $params
     */
    public function syncCategories(array $params)
    {
        $this->model->categories()->sync($params);
    }

    /**
     * @param $file
     * @param null $disk
     * @return bool
     */
    public function deleteFile(array $file, $disk = null) : bool
    {
        return $this->update(['cover' => null], $file['product']);
    }

    /**
     * Get the product via slug
     *
     * @param array $slug
     * @return Product
     */
    public function findProductBySlug(array $slug) : Product
    {
        try {
            return $this->findOneByOrFail($slug);
        } catch (ModelNotFoundException $e) {
            throw new ProductNotFoundException($e->getMessage());
        }
    }

    /**
     * Upload the image
     *
     * @param $image
     * @param string $folder
     * @return false|string
     */
    public function uploadOneImage($image, $folder = 'products')
    {
        return $this->uploadOne($image, $folder);
    }
}
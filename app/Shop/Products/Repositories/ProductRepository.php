<?php

namespace App\Shop\Products\Repositories;

use App\Shop\Base\BaseRepository;
use App\Shop\Products\Exceptions\ProductInvalidArgumentException;
use App\Shop\Products\Exceptions\ProductNotFoundException;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\Tools\UploadableTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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
        $this->model = $product;
    }

    /**
     * List all the products
     *
     * @param string $order
     * @param string $sort
     * @param array $columns
     * @return Collection
     */
    public function listProducts(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection
    {
        return $this->all($columns, $order, $sort);
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
            $product = new Product($params);
            $product->save();

            if (isset($params['thumbnails'])) {
                $this->saveThumbnails($params['thumbnails'], $product);
            }

            return $product;
        } catch (QueryException $e) {
            throw new ProductInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Update the product
     *
     * @param array $params
     * @param int $id
     * @return bool
     */
    public function updateProduct(array $params, int $id) : bool
    {
        try {
            $collection = collect($params)->except('_token');
            $slug = str_slug($collection->get('name'));

            if (request()->hasFile('cover')) {
                $cover = $this->uploadOneImage(request()->file('cover'));
            }

            $merge = $collection->merge(compact('slug', 'cover'));
            return $this->update($merge->all(), $id);
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
     * @param string $src
     * @return bool
     */
    public function deleteThumb(string $src) : bool
    {
        return DB::table('product_images')->where('src', $src)->delete();
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
    public function uploadOneImage(UploadedFile $image, $folder = 'products')
    {
        return $this->uploadOne($image, $folder);
    }

    /**
     * @param string $text
     * @return mixed
     */
    public function searchProduct(string $text) : Collection
    {
        return $this->model->search($text)->get();
    }

    /**
     * @return mixed
     */
    public function findProductImages() : Collection
    {
        return $this->model->images()->get();
    }

    /**
     * @param array $thumbnails
     * @param Product $product
     */
    private function saveThumbnails(array $thumbnails, Product $product)
    {
        collect($thumbnails)->each(function ($filename) use ($product) {
            DB::table('product_images')->insert([
                'product_id' => $product->id,
                'src' => $filename
            ]);
        });
    }
}

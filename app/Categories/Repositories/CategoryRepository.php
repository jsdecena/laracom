<?php

namespace App\Categories\Repositories;

use App\Base\BaseRepository;
use App\Categories\Category;
use App\Categories\Exceptions\CategoryInvalidArgumentException;
use App\Categories\Exceptions\CategoryNotFoundException;
use App\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Products\Product;
use App\Products\Transformations\ProductTransformable;
use App\Tools\UploadableTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    use UploadableTrait, ProductTransformable;

    /**
     * CategoryRepository constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        $this->model = $category;
    }

    /**
     * List all the categories
     *
     * @param string $order
     * @param string $sort
     * @return array
     */
    public function listCategories(string $order = 'id', string $sort = 'desc') : array
    {
        $list = $this->model->orderBy($order, $sort)->get();

        return collect($list)->all();
    }

    /**
     * Create the category
     *
     * @param array $params
     * @return Category
     * @throws CategoryInvalidArgumentException
     */
    public function createCategory(array $params) : Category
    {
        try {

            $collection = collect($params)->except('_token');
            $slug = str_slug($collection->get('name'));

            if (request()->hasFile('cover')) {
                $file = request()->file('cover', 'products');
                $cover = $this->uploadOne($file, 'categories');
            }

            $merge = $collection->merge(compact('slug', 'cover'));

            $category = new Category($merge->all());
            $category->save();
            return $category;

        } catch (QueryException $e) {
            throw new CategoryInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Update the category
     *
     * @param array $params
     * @return Category
     */
    public function updateCategory(array $params) : Category
    {
        $category = $this->findCategoryById($this->model->id);
        $collection = collect($params)->except('_token');
        $slug = str_slug($collection->get('name'));

        if (request()->hasFile('cover')) {
            $file = request()->file('cover', 'products');
            $cover = $this->uploadOne($file, 'categories');
        }

        $merge = $collection->merge(compact('slug', 'cover'));

        $category->update($merge->all());
        return $category;
    }

    /**
     * @param int $id
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function findCategoryById(int $id) : Category
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException($e->getMessage());
        }
    }

    /**
     * Delete a category
     *
     * @return bool
     */
    public function deleteCategory() : bool
    {
        return $this->model->delete();
    }

    /**
     * Associate a product in a category
     *
     * @param Product $product
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function associateProduct(Product $product)
    {
        return $this->model->products()->save($product);
    }

    /**
     * Return all the products associated with the category
     *
     * @return mixed
     */
    public function findProducts()
    {
        return collect($this->model->products)->map(function (Product $product) {
            return $this->transformProduct($product);
        })->sortByDesc('id');
    }

    /**
     * @param array $params
     */
    public function syncProducts(array $params)
    {
        $this->model->products()->sync($params);
    }


    /**
     * Detach the association of the product
     *
     */
    public function detachProducts()
    {
        $this->model->products()->detach();
    }

    /**
     * @param $file
     * @param null $disk
     * @return bool
     */
    public function deleteFile(array $file, $disk = null) : bool
    {
        return $this->update(['cover' => null], $file['category']);
    }

    /**
     * Return the category by using the slug as the parameter
     *
     * @param array $slug
     * @return Category
     */
    public function findCategoryBySlug(array $slug) : Category
    {
        try {
            return $this->findOneByOrFail($slug);
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException($e->getMessage());
        }
    }

    /**
     * Find products under a specific category
     *
     * @param int $id
     * @return mixed
     */
    public function findProductsInCategory(int $id)
    {
        $products = [];
        foreach ($this->all() as $category) {
            if ($category->id == $id) {
                $products[] = ($this->findCategoryById($id))->products;
            }
        }

        return collect($products[0])->map(function (Product $product){
            return $this->transformProduct($product);
        });
    }
}
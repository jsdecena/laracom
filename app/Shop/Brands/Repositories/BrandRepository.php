<?php

namespace App\Shop\Brands\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Brands\Brand;
use App\Shop\Brands\Exceptions\BrandNotFoundErrorException;
use App\Shop\Brands\Exceptions\CreateBrandErrorException;
use App\Shop\Brands\Exceptions\UpdateBrandErrorException;
use App\Shop\Products\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    /**
     * BrandRepository constructor.
     *
     * @param Brand $brand
     */
    public function __construct(Brand $brand)
    {
        parent::__construct($brand);
        $this->model = $brand;
    }

    /**
     * @param array $data
     *
     * @return Brand
     * @throws CreateBrandErrorException
     */
    public function createBrand(array $data) : Brand
    {
        try {
            return $this->create($data);
        } catch (QueryException $e) {
            throw new CreateBrandErrorException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return Brand
     * @throws BrandNotFoundErrorException
     */
    public function findBrandById(int $id) : Brand
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new BrandNotFoundErrorException($e);
        }
    }

    /**
     * @param array $data
     * @param int $id
     *
     * @return bool
     * @throws UpdateBrandErrorException
     */
    public function updateBrand(array $data) : bool
    {
        try {
            return $this->update($data);
        } catch (QueryException $e) {
            throw new UpdateBrandErrorException($e);
        }
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function deleteBrand() : bool
    {
        return $this->delete();
    }

    /**
     * @param array $columns
     * @param string $orderBy
     * @param string $sortBy
     *
     * @return Collection
     */
    public function listBrands($columns = array('*'), string $orderBy = 'id', string $sortBy = 'asc') : Collection
    {
        return $this->all($columns, $orderBy, $sortBy);
    }

    /**
     * @return Collection
     */
    public function listProducts() : Collection
    {
        return $this->model->products()->get();
    }

    /**
     * @param Product $product
     */
    public function saveProduct(Product $product)
    {
        $this->model->products()->save($product);
    }

    /**
     * Dissociate the products
     */
    public function dissociateProducts()
    {
        $this->model->products()->each(function (Product $product) {
            $product->brand_id = null;
            $product->save();
        });
    }
}

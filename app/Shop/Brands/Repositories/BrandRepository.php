<?php

namespace App\Shop\Brands\Repositories;

use App\Shop\Base\BaseRepository;
use App\Shop\Brands\Brand;
use App\Shop\Brands\Exceptions\BrandNotFoundErrorException;
use App\Shop\Brands\Exceptions\CreateBrandErrorException;
use App\Shop\Brands\Exceptions\DeletingBrandErrorException;
use App\Shop\Brands\Exceptions\UpdateBrandErrorException;
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
    public function updateBrand(array $data, int $id) : bool
    {
        try {
            return $this->update($data, $id);
        } catch (QueryException $e) {
            throw new UpdateBrandErrorException($e);
        }
    }

    /**
     * @param int $id
     *
     * @return bool
     * @throws DeletingBrandErrorException
     */
    public function deleteBrand(int $id) : bool
    {
        try {
            return $this->delete($id);
        } catch (QueryException $e) {
            throw new DeletingBrandErrorException($e);
        }
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
}
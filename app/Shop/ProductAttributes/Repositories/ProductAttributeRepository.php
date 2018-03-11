<?php

namespace App\Shop\ProductAttributes\Repositories;

use App\Shop\Base\BaseRepository;
use App\Shop\ProductAttributes\Exceptions\CreateProductAttributeErrorException;
use App\Shop\ProductAttributes\ProductAttribute;
use Illuminate\Database\QueryException;

class ProductAttributeRepository extends BaseRepository implements ProductAttributeRepositoryInterface
{
    /**
     * ProductAttributeRepository constructor.
     * @param ProductAttribute $attribute
     */
    public function __construct(ProductAttribute $attribute)
    {
        parent::__construct($attribute);
        $this->model = $attribute;
    }

    /**
     * @param array $data
     * @return ProductAttribute
     * @throws CreateProductAttributeErrorException
     */
    public function createProductAttribute(array $data) : ProductAttribute
    {
        try {

            $productAttribute = new ProductAttribute($data);
            $productAttribute->save();

            return $productAttribute;

        } catch (QueryException $e) {
            throw new CreateProductAttributeErrorException($e);
        }
    }

    /**
     * @return bool|null
     */
    public function removeProductAttribute() : ?bool
    {
        return $this->model->delete();
    }
}
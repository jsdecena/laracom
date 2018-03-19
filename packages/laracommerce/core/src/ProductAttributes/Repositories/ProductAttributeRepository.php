<?php

namespace Laracommerce\Core\ProductAttributes\Repositories;

use Laracommerce\Core\Base\BaseRepository;
use Laracommerce\Core\ProductAttributes\Exceptions\ProductAttributeNotFoundException;
use Laracommerce\Core\ProductAttributes\ProductAttribute;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductAttributeRepository extends BaseRepository implements ProductAttributeRepositoryInterface
{
    /**
     * ProductAttributeRepository constructor.
     * @param ProductAttribute $productAttribute
     */
    public function __construct(ProductAttribute $productAttribute)
    {
        parent::__construct($productAttribute);
        $this->model = $productAttribute;
    }

    /**
     * @param int $id
     * @return mixed
     * @throws ProductAttributeNotFoundException
     */
    public function findProductAttributeById(int $id)
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            throw new ProductAttributeNotFoundException($e);
        }
    }
}

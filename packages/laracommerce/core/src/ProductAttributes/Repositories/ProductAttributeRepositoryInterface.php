<?php

namespace Laracommerce\Core\ProductAttributes\Repositories;

use Laracommerce\Core\Base\Interfaces\BaseRepositoryInterface;

interface ProductAttributeRepositoryInterface extends BaseRepositoryInterface
{
    public function findProductAttributeById(int $id);
}

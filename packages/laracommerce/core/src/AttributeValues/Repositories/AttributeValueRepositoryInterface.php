<?php

namespace Laracommerce\Core\AttributeValues\Repositories;

use Laracommerce\Core\Attributes\Attribute;
use Laracommerce\Core\AttributeValues\AttributeValue;
use Laracommerce\Core\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface AttributeValueRepositoryInterface extends BaseRepositoryInterface
{
    public function createAttributeValue(Attribute $attribute, array $data) : AttributeValue;

    public function associateToAttribute(Attribute $attribute) : AttributeValue;

    public function dissociateFromAttribute() : bool;

    public function findProductAttributes() : Collection;
}

<?php

namespace App\Shop\AttributeValues\Repositories;

use App\Shop\Attributes\Attribute;
use App\Shop\AttributeValues\AttributeValue;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;
use Illuminate\Support\Collection;

interface AttributeValueRepositoryInterface extends BaseRepositoryInterface
{
    public function createAttributeValue(Attribute $attribute, array $data) : AttributeValue;

    public function associateToAttribute(Attribute $attribute) : AttributeValue;

    public function dissociateFromAttribute() : bool;

    public function findProductAttributes() : Collection;
}

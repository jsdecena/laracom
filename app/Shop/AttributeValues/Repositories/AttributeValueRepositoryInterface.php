<?php

namespace App\Shop\AttributeValues\Repositories;

use App\Shop\Attributes\Attribute;
use App\Shop\AttributeValues\AttributeValue;
use App\Shop\Base\Interfaces\BaseRepositoryInterface;

interface AttributeValueRepositoryInterface extends BaseRepositoryInterface
{
    public function associateToAttribute(Attribute $attribute) : AttributeValue;

    public function dissociateFromAttribute() : bool;
}
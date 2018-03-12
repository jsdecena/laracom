<?php

namespace App\Shop\AttributeValues\Repositories;

use App\Shop\Attributes\Attribute;
use App\Shop\AttributeValues\AttributeValue;
use App\Shop\Base\BaseRepository;

class AttributeValueRepository extends BaseRepository implements AttributeValueRepositoryInterface
{
    /**
     * AttributeValueRepository constructor.
     * @param AttributeValue $attributeValue
     */
    public function __construct(AttributeValue $attributeValue)
    {
        parent::__construct($attributeValue);
        $this->model = $attributeValue;
    }

    /**
     * Create the attribute value and associate to the attribute
     *
     * @param Attribute $attribute
     * @return AttributeValue
     */
    public function associateToAttribute(Attribute $attribute) : AttributeValue
    {
        $this->model->attribute()->associate($attribute);
        $this->model->save();
        return $this->model;
    }

    /**
     * Remove association from the attribute
     */
    public function dissociateFromAttribute() : bool
    {
        return $this->model->delete();
    }
}
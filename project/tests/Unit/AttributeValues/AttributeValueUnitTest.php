<?php

namespace Tests\Unit\AttributeValues;

use App\Shop\Attributes\Attribute;
use App\Shop\AttributeValues\AttributeValue;
use App\Shop\AttributeValues\Repositories\AttributeValueRepository;
use Tests\TestCase;

class AttributeValueUnitTest extends TestCase
{
    /** @test */
    public function it_can_be_dissociated_from_the_attribute()
    {
        $attributeValue = new AttributeValue(['value' => 'small']);
        $attributeValueRepo = new AttributeValueRepository($attributeValue);

        $attribute = factory(Attribute::class)->create();
        $createdValue = $attributeValueRepo->associateToAttribute($attribute);

        $attributeValueRepo2 = new AttributeValueRepository($createdValue);
        $removedAttribute = $attributeValueRepo2->dissociateFromAttribute();

        $this->assertTrue($removedAttribute);
    }
    
    /** @test */
    public function it_can_be_associated_with_the_attribute()
    {
        $attributeValue = new AttributeValue(['value' => 'sizes']);
        $attributeValueRepo = new AttributeValueRepository($attributeValue);

        $attribute = factory(Attribute::class)->create();
        $attributeValueRepo->associateToAttribute($attribute);

        $this->assertCount(1, $attribute->values->all());
    }
}

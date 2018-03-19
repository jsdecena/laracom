<?php

namespace Tests\Unit\ProductAttributeCombinations;

use Laracommerce\Core\Attributes\Attribute;
use Laracommerce\Core\AttributeValues\AttributeValue;
use Laracommerce\Core\AttributeValues\Repositories\AttributeValueRepository;
use Laracommerce\Core\ProductAttributes\ProductAttribute;
use Laracommerce\Core\Products\Product;
use Laracommerce\Core\Products\Repositories\ProductRepository;
use Tests\TestCase;

class ProductAttributeCombinationsUnitTest extends TestCase
{
    /** @test */
    public function it_can_create_a_product_attribute_combinations()
    {
        /**
         * Create:
         *  - Attribute: Sizes
         *    - Attribute value: small
         *  - Attribute: Colors
         *    - Attribute value: red
         */

        $attributeValue1 = new AttributeValue(['value' => 'small']);
        $attributeValueRepo1 = new AttributeValueRepository($attributeValue1);

        $attribute1 = factory(Attribute::class)->create(['name' => 'Sizes']);
        $createdValue1 = $attributeValueRepo1->associateToAttribute($attribute1);

        $attributeValue2 = new AttributeValue(['value' => 'red']);
        $attributeValueRepo2 = new AttributeValueRepository($attributeValue2);

        $attribute2 = factory(Attribute::class)->create(['name' => 'Colors']);
        $createdValue2 = $attributeValueRepo2->associateToAttribute($attribute2);

        $data = [
            'quantity' => 2,
            'price' => 2.50
        ];

        $productAttribute = new ProductAttribute($data);
        $product = factory(Product::class)->create();

        $productRepo = new ProductRepository($product);
        $created = $productRepo->saveProductAttributes($productAttribute);

        $combinations = $productRepo->saveCombination($created, $createdValue1, $createdValue2);

        $this->assertCount(2, $combinations);
    }
}

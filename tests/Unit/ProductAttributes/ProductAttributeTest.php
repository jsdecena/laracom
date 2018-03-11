<?php

namespace Tests\Unit\ProductAttributes;

use App\Shop\ProductAttributes\ProductAttribute;
use App\Shop\ProductAttributes\Repositories\ProductAttributeRepository;
use Tests\TestCase;

class ProductAttributeTest extends TestCase
{
    /** @test */
    public function it_returns_null_deleting_non_existing_product_attribute()
    {
        $productAttributeRepo = new ProductAttributeRepository(new ProductAttribute);
        $deleted = $productAttributeRepo->removeProductAttribute();

        $this->assertNull($deleted);
    }

    /** @test */
    public function it_can_remove_product_attribute()
    {
        $productAttribute = factory(ProductAttribute::class)->create();

        $productAttributeRepo = new ProductAttributeRepository($productAttribute);
        $deleted = $productAttributeRepo->removeProductAttribute();

        $this->assertTrue($deleted);
    }

    /** @test */
    public function it_can_create_product_attribute()
    {
        $data = [
            'quantity' => 1,
            'price' => 10.45
        ];

        $productAttributeRepo = new ProductAttributeRepository(new ProductAttribute);
        $productAttribute = $productAttributeRepo->createProductAttribute($data);

        $this->assertInstanceOf(ProductAttribute::class, $productAttribute);
        $this->assertEquals($data['quantity'], $productAttribute->quantity);
        $this->assertEquals($data['price'], $productAttribute->price);
    }
}
<?php

namespace Tests\Unit\ProductAttributes;

use App\Shop\ProductAttributes\ProductAttribute;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use Tests\TestCase;

class ProductAttributeUnitTest extends TestCase
{
    /** @test */
    public function it_returns_null_deleting_non_existing_product_attribute()
    {
        $product = factory(Product::class)->create();
        $productRepo = new ProductRepository($product);
        $deleted = $productRepo->removeProductAttribute(new ProductAttribute);

        $this->assertNull($deleted);
    }

    /** @test */
    public function it_can_remove_product_attribute()
    {
        $data = [
            'quantity' => 1,
            'price' => 10.45
        ];

        $productAttribute = new ProductAttribute($data);

        $product = factory(Product::class)->create();
        $productRepo = new ProductRepository($product);
        $created = $productRepo->saveProductAttributes($productAttribute);

        $deleted = $productRepo->removeProductAttribute($created);

        $this->assertTrue($deleted);
    }

    /** @test */
    public function it_can_create_product_attribute()
    {
        $data = [
            'quantity' => 1,
            'price' => 10.45
        ];

        $productAttribute = new ProductAttribute($data);

        $product = factory(Product::class)->create();
        $productRepo = new ProductRepository($product);
        $created = $productRepo->saveProductAttributes($productAttribute);

        $this->assertInstanceOf(ProductAttribute::class, $created);
        $this->assertInstanceOf(Product::class, $productAttribute->product);

        $this->assertEquals($data['quantity'], $created->quantity);
        $this->assertEquals($data['price'], $created->price);
        $this->assertEquals($product->name, $created->product->name);
        $this->assertEquals($product->price, $created->product->price);
    }
}

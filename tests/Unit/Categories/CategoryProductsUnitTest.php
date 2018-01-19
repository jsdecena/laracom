<?php

namespace Tests\Unit\Categories;

use App\Shop\Categories\Category;
use App\Shop\Categories\Repositories\CategoryRepository;
use Tests\TestCase;

class CategoryProductsUnitTest extends TestCase
{
    /** @test */
    public function it_can_retrieve_the_products_from_the_category()
    {
        $category = new CategoryRepository($this->category);
        $category->associateProduct($this->product);

        $products = $category->findProducts();

        foreach ($products as $product) {
            $this->assertEquals($this->product->sku, $product->sku);
            $this->assertEquals($this->product->name, $product->name);
            $this->assertEquals($this->product->description, $product->description);
            $this->assertEquals($this->product->quantity, $product->quantity);
            $this->assertEquals($this->product->price, $product->price);
        }
    }
    
    /** @test */
    public function it_can_associate_the_product_in_the_category()
    {
        $category = new CategoryRepository($this->category);
        $product = $category->associateProduct($this->product);

        $this->assertEquals($this->product->sku, $product->sku);
        $this->assertEquals($this->product->name, $product->name);
        $this->assertEquals($this->product->description, $product->description);
        $this->assertEquals($this->product->quantity, $product->quantity);
        $this->assertEquals($this->product->price, $product->price);
    }
}

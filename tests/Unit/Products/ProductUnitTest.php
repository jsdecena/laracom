<?php

namespace Tests\Unit\Products;

use App\Shop\ProductImages\ProductImage;
use App\Shop\ProductImages\ProductImageRepository;
use App\Shop\Products\Exceptions\ProductInvalidArgumentException;
use App\Shop\Products\Exceptions\ProductNotFoundException;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductUnitTest extends TestCase
{
    /** @test */
    public function it_can_show_the_product_where_the_image_belongs_to()
    {
        $product = 'apple';
        $cover = UploadedFile::fake()->image('file.png', 600, 600);

        $params = [
            'sku' => $this->faker->numberBetween(1111111, 999999),
            'name' => $product,
            'slug' => str_slug($product),
            'description' => $this->faker->paragraph,
            'cover' => $cover,
            'quantity' => 10,
            'price' => 9.95,
            'status' => 1,
            'image' => [
                UploadedFile::fake()->image('file.png', 200, 200),
                UploadedFile::fake()->image('file1.png', 200, 200),
                UploadedFile::fake()->image('file2.png', 200, 200)
            ]
        ];

        $productRepo = new ProductRepository(new Product);
        $created = $productRepo->createProduct($params);
        $repo = new ProductRepository($created);
        $thumbnails = $repo->findProductImages();

        $thumbnails->each(function (ProductImage $item) use ($created) {
            $this->assertInstanceOf(ProductImage::class, $item);

            $productImageRepo = new ProductImageRepository($item);
            $product = $productImageRepo->findProduct();

            $this->assertEquals($created->name, $product->name);
            $this->assertEquals($created->description, $product->description);
        });
    }

    /** @test */
    public function it_can_delete_a_thumbnail_image()
    {
        $product = 'apple';
        $cover = UploadedFile::fake()->image('file.png', 600, 600);

        $params = [
            'sku' => $this->faker->numberBetween(1111111, 999999),
            'name' => $product,
            'slug' => str_slug($product),
            'description' => $this->faker->paragraph,
            'cover' => $cover,
            'quantity' => 10,
            'price' => 9.95,
            'status' => 1,
            'image' => [
                UploadedFile::fake()->image('file.png', 200, 200),
                UploadedFile::fake()->image('file1.png', 200, 200),
                UploadedFile::fake()->image('file2.png', 200, 200)
            ]
        ];

        $productRepo = new ProductRepository(new Product);
        $created = $productRepo->createProduct($params);
        $repo = new ProductRepository($created);
        $thumbnails = $repo->findProductImages();

        $this->assertCount(3, $repo->findProductImages());
        $thumbnails->each(function ($thumbnail) {
            $repo = new ProductRepository(new Product());
            $repo->deleteThumb($thumbnail->src);
        });

        $this->assertCount(0, $repo->findProductImages());
    }
    
    /** @test */
    public function it_can_show_all_the_product_images()
    {
        $product = 'apple';
        $cover = UploadedFile::fake()->image('file.png', 600, 600);

        $params = [
            'sku' => $this->faker->numberBetween(1111111, 999999),
            'name' => $product,
            'slug' => str_slug($product),
            'description' => $this->faker->paragraph,
            'cover' => $cover,
            'quantity' => 10,
            'price' => 9.95,
            'status' => 1,
            'image' => [
                UploadedFile::fake()->image('file.png', 200, 200),
                UploadedFile::fake()->image('file1.png', 200, 200),
                UploadedFile::fake()->image('file2.png', 200, 200)
            ]
        ];

        $productRepo = new ProductRepository(new Product);
        $created = $productRepo->createProduct($params);

        $repo = new ProductRepository($created);
        $this->assertCount(3, $repo->findProductImages());
    }

    /** @test */
    public function it_can_search_the_product()
    {
        $products = factory(Product::class, 5)->create();

        $name = str_limit($products->get(1)->name, 2);

        $productRepo = new ProductRepository(new Product);
        $results = $productRepo->searchProduct($name);

        foreach ($results->toArray() as $result) {
            $this->assertContains($name, $result->name);
        }
    }
    
    /** @test */
    public function it_can_delete_the_file_only_by_updating_the_database()
    {
        $product = new ProductRepository($this->product);
        $product->deleteFile(['product' => $this->product->id]);
    }
    
    /** @test */
    public function it_errors_when_the_slug_in_not_found()
    {
        $this->expectException(ProductNotFoundException::class);

        $product = new ProductRepository($this->product);
        $product->findProductBySlug(['slug' => 'unknown']);
    }
    
    /** @test */
    public function it_can_find_the_product_with_the_slug()
    {
        $product = new ProductRepository($this->product);
        $found = $product->findProductBySlug(['slug' => $this->product->slug]);

        $this->assertEquals($this->product->name, $found->name);
    }
    
    /** @test */
    public function it_errors_updating_the_product_with_required_fields_are_not_passed()
    {
        $this->expectException(ProductInvalidArgumentException::class);

        $product = new ProductRepository($this->product);
        $product->updateProduct(['name' => null], $this->product->id);
    }
    
    /** @test */
    public function it_errors_creating_the_product_when_required_fields_are_not_passed()
    {
        $this->expectException(ProductInvalidArgumentException::class);

        $product = new ProductRepository(new Product);
        $product->createProduct([]);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $product = new ProductRepository(new Product);
        $product->deleteProduct($this->product);

        $this->assertDatabaseMissing('products', collect($this->product)->all());
    }

    /** @test */
    public function it_can_list_all_the_products()
    {
        $product = new ProductRepository(new Product);
        $list = $product->listProducts()->toArray();

        $this->arrayHasKey(array_keys($list));
    }

    /** @test */
    public function it_errors_finding_a_product()
    {
        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage('Product not found.');

        $product = new ProductRepository(new Product);
        $product->findProductById(999);
    }

    /** @test */
    public function it_can_find_the_product()
    {
        $product = new ProductRepository(new Product);
        $found = $product->findProductById($this->product->id);

        $this->assertInstanceOf(Product::class, $found);
        $this->assertEquals($this->product->sku, $found->sku);
        $this->assertEquals($this->product->name, $found->name);
        $this->assertEquals($this->product->slug, $found->slug);
        $this->assertEquals($this->product->description, $found->description);
        $this->assertEquals($this->product->quantity, $found->quantity);
        $this->assertEquals($this->product->price, $found->price);
        $this->assertEquals($this->product->status, $found->status);
    }

    /** @test */
    public function it_can_update_a_product()
    {
        $product = factory(Product::class)->create();
        $productName = 'apple';
        $cover = UploadedFile::fake()->image('file.png', 600, 600);

        $params = [
            'sku' => '11111',
            'name' => $productName,
            'slug' => str_slug($productName),
            'description' => $this->faker->paragraph,
            'cover' => $cover,
            'quantity' => 11,
            'price' => 9.95,
            'status' => 1,
            'image' => [
                UploadedFile::fake()->image('file.png', 200, 200),
                UploadedFile::fake()->image('file1.png', 200, 200),
                UploadedFile::fake()->image('file2.png', 200, 200)
            ]
        ];

        $productRepo = new ProductRepository($product);
        $updated = $productRepo->updateProduct($params, $product->id);

        $this->assertTrue($updated);
    }

    /** @test */
    public function it_can_create_a_product()
    {
        $product = 'apple';
        $cover = UploadedFile::fake()->image('file.png', 600, 600);

        $params = [
            'sku' => $this->faker->numberBetween(1111111, 999999),
            'name' => $product,
            'slug' => str_slug($product),
            'description' => $this->faker->paragraph,
            'cover' => $cover,
            'quantity' => 10,
            'price' => 9.95,
            'status' => 1,
        ];

        $product = new ProductRepository(new Product);
        $created = $product->createProduct($params);

        $this->assertInstanceOf(Product::class, $created);
        $this->assertEquals($params['sku'], $created->sku);
        $this->assertEquals($params['name'], $created->name);
        $this->assertEquals($params['slug'], $created->slug);
        $this->assertEquals($params['description'], $created->description);
        $this->assertEquals($params['cover'], $created->cover);
        $this->assertEquals($params['quantity'], $created->quantity);
        $this->assertEquals($params['price'], $created->price);
        $this->assertEquals($params['status'], $created->status);
    }
}

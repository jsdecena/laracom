<?php

namespace Tests\Unit\Products;

use App\Shop\Categories\Category;
use App\Shop\ProductImages\ProductImage;
use App\Shop\ProductImages\ProductImageRepository;
use App\Shop\Products\Exceptions\ProductCreateErrorException;
use App\Shop\Products\Exceptions\ProductNotFoundException;
use App\Shop\Products\Exceptions\ProductUpdateErrorException;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProductUnitTest extends TestCase
{
    /** @test */
    public function it_can_return_the_product_of_the_cover_image()
    {
        $thumbnails = [
            UploadedFile::fake()->image('cover.jpg', 600, 600),
            UploadedFile::fake()->image('cover.jpg', 600, 600),
            UploadedFile::fake()->image('cover.jpg', 600, 600)
        ];

        $collection = collect($thumbnails);

        $product = factory(Product::class)->create();
        $productRepo = new ProductRepository($product);
        $productRepo->saveProductImages($collection, $product);

        $images = $productRepo->findProductImages();

        $images->each(function (ProductImage $image) use ($product) {
            $productImageRepo = new ProductImageRepository($image);
            $foundProduct = $productImageRepo->findProduct();

            $this->assertInstanceOf(Product::class, $foundProduct);
            $this->assertEquals($product->name, $foundProduct->name);
            $this->assertEquals($product->slug, $foundProduct->slug);
            $this->assertEquals($product->description, $foundProduct->description);
            $this->assertEquals($product->quantity, $foundProduct->quantity);
            $this->assertEquals($product->price, $foundProduct->price);
            $this->assertEquals($product->status, $foundProduct->status);
        });
    }

    /** @test */
    public function it_can_save_the_thumbnails_properly_in_the_file_storage()
    {
        $thumbnails = [
            UploadedFile::fake()->image('cover.jpg', 600, 600),
            UploadedFile::fake()->image('cover.jpg', 600, 600),
            UploadedFile::fake()->image('cover.jpg', 600, 600)
        ];

        $collection = collect($thumbnails);

        $product = factory(Product::class)->create();
        $productRepo = new ProductRepository($product);
        $productRepo->saveProductImages($collection, $product);

        $images = $productRepo->findProductImages();

        $images->each(function (ProductImage $image) {
            $exists = Storage::disk('public')->exists($image->src);
            $this->assertTrue($exists);
        });
    }

    /** @test */
    public function it_can_save_the_cover_image_properly_in_file_storage()
    {
        $cover = UploadedFile::fake()->image('cover.jpg', 600, 600);

        $product = factory(Product::class)->create();
        $productRepo = new ProductRepository($product);
        $filename = $productRepo->saveCoverImage($cover);

        $exists = Storage::disk('public')->exists($filename);

        $this->assertTrue($exists);
    }

    /** @test */
    public function it_can_detach_all_the_categories()
    {
        $product = factory(Product::class)->create();
        $categories = factory(Category::class, 4)->create();

        $productRepo = new ProductRepository($product);

        $ids = $categories->transform(function (Category $category) {
            return $category->id;
        })->all();

        $productRepo->syncCategories($ids);

        $this->assertCount(4, $productRepo->getCategories());

        $productRepo->detachCategories();

        $this->assertCount(0, $productRepo->getCategories());
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
        $repo->saveProductImages(collect($params['image']), $created);
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
        $repo->saveProductImages(collect($params['image']), $created);
        $this->assertCount(3, $repo->findProductImages());
    }

    /** @test */
    public function it_can_search_the_product()
    {
        $product = factory(Product::class)->create();

        $name = str_limit($product->name, 2, '');

        $productRepo = new ProductRepository($product);
        $results = $productRepo->searchProduct($name);

        $this->assertGreaterThan(0, $results->count());
    }

    /** @test */
    public function it_can_delete_the_file_only_by_updating_the_database()
    {
        $product = new ProductRepository($this->product);
        $this->assertTrue($product->deleteFile(['product' => $this->product->id]));
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
        $this->expectException(ProductUpdateErrorException::class);

        $product = new ProductRepository($this->product);
        $product->updateProduct(['name' => null]);
    }

    /** @test */
    public function it_errors_creating_the_product_when_required_fields_are_not_passed()
    {
        $this->expectException(ProductCreateErrorException::class);

        $product = new ProductRepository(new Product);
        $product->createProduct([]);
    }

    /** @test */
    public function it_can_delete_a_product()
    {
        $product = factory(Product::class)->create();
        $productRepo = new ProductRepository($product);

        $thumbnails = [
            UploadedFile::fake()->image('file.png', 200, 200),
            UploadedFile::fake()->image('file1.png', 200, 200),
            UploadedFile::fake()->image('file2.png', 200, 200)
        ];

        $productRepo->saveProductImages(collect($thumbnails));
        $deleted = $productRepo->removeProduct($product);

        $this->assertTrue($deleted);
        $this->assertDatabaseMissing('products', ['name' => $product->name]);
    }

    /** @test */
    public function it_can_list_all_the_products()
    {
        $product = factory(Product::class)->create();
        $attributes = $product->getFillable();

        $productRepo = new ProductRepository(new Product);
        $products = $productRepo->listProducts();

        $products->each(function ($product, $key) use ($attributes) {
            foreach ($product->getFillable() as $key => $value) {
                $this->assertArrayHasKey($key, $attributes);
            }
        });
    }

    /** @test */
    public function it_errors_finding_a_product()
    {
        $this->expectException(ProductNotFoundException::class);

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

        $data = [
            'sku' => '11111',
            'name' => $productName,
            'slug' => str_slug($productName),
            'description' => $this->faker->paragraph,
            'cover' => $cover,
            'quantity' => 11,
            'price' => 9.95,
            'status' => 1
        ];

        $productRepo = new ProductRepository($product);
        $updated = $productRepo->updateProduct($data);

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

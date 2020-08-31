<?php

namespace Tests\Feature;

use App\Shop\Categories\Category;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProductFeatureTest extends TestCase
{
    /** @test */
    public function it_can_show_the_product()
    {
        $product = factory(Product::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.products.show', $product->id))
            ->assertStatus(200)
            ->assertSee($product->name);
    }
    
    /** @test */
    public function it_can_search_the_product()
    {
        $product = factory(Product::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.products.index', ['q' => str_limit($product->name, 5, '')]))
            ->assertStatus(200)
            ->assertSee($product->name);
    }

    /** @test */
    public function it_can_remove_the_thumbnail()
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

        $productRepo = new ProductRepository(new Product());
        $created = $productRepo->createProduct($params);
        $repo = new ProductRepository($created);
        $repo->saveProductImages(collect($params['image']), $created);
        $image = $repo->findProductImages()->first();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.product.remove.thumb', ['src' => $image->src]))
            ->assertStatus(302)
            ->assertRedirect(url('/'))
            ->assertSessionHas('message', 'Image delete successful');
    }
    
    /** @test */
    public function it_can_remove_the_cover_image()
    {
        $product = factory(Product::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.product.remove.image', ['product' => $product->id, 'image' => substr($product->cover, 9)]))
            ->assertStatus(302)
            ->assertRedirect(url('/'))
            ->assertSessionHas('message', 'Image delete successful');
    }
    
    /** @test */
    public function it_can_delete_the_product()
    {
        $product = factory(Product::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->delete(route('admin.products.destroy', $product->id))
            ->assertStatus(302)
            ->assertRedirect(route('admin.products.index'))
            ->assertSessionHas('message', 'Delete successful');
    }

    /** @test */
    public function it_can_list_all_products()
    {
        $product = factory(Product::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.products.index'))
            ->assertStatus(200)
            ->assertSee($product->name);
    }

    /** @test */
    public function it_can_show_the_product_edit_page()
    {
        $product = factory(Product::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.products.edit', $product->id))
            ->assertStatus(200)
            ->assertSee($product->name);
    }
    
    /** @test */
    public function it_can_show_the_product_create()
    {
        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.products.create'))
            ->assertStatus(200);
    }

    /** @test */
    public function it_can_create_the_product_with_categories()
    {
        $product = 'apple';
        $cover = UploadedFile::fake()->image('file.png', 600, 600);

        $thumbnails = [
            UploadedFile::fake()->image('cover.jpg', 600, 600),
            UploadedFile::fake()->image('cover.jpg', 600, 600),
            UploadedFile::fake()->image('cover.jpg', 600, 600)
        ];

        $categories = factory(Category::class, 2)->create();

        $categoryIds = $categories->transform(function (Category $category) {
            return $category->id;
        })->all();

        $params = [
            'sku' => $this->faker->numberBetween(1111111, 999999),
            'name' => $product,
            'slug' => str_slug($product),
            'description' => $this->faker->paragraph,
            'cover' => $cover,
            'quantity' => 10,
            'price' => 9.95,
            'status' => 1,
            'categories' => $categoryIds,
            'image' => $thumbnails
        ];

        $this
            ->actingAs($this->employee, 'employee')
            ->post(route('admin.products.store'), $params)
            ->assertStatus(302)
            ->assertRedirect(route('admin.products.edit', 2))
            ->assertSessionHas('message', 'Create successful');
    }
    
    /** @test */
    public function it_can_create_the_product()
    {
        $product = 'apple';
        $cover = UploadedFile::fake()->image('file.png', 600, 600);

        $thumbnails = [
            UploadedFile::fake()->image('cover.jpg', 600, 600),
            UploadedFile::fake()->image('cover.jpg', 600, 600),
            UploadedFile::fake()->image('cover.jpg', 600, 600)
        ];

        $params = [
            'sku' => $this->faker->numberBetween(1111111, 999999),
            'name' => $product,
            'slug' => str_slug($product),
            'description' => $this->faker->paragraph,
            'cover' => $cover,
            'quantity' => 10,
            'price' => 9.95,
            'status' => 1,
            'image' => $thumbnails
        ];

        $this
            ->actingAs($this->employee, 'employee')
            ->post(route('admin.products.store'), $params)
            ->assertStatus(302)
            ->assertRedirect(route('admin.products.edit', 2))
            ->assertSessionHas('message', 'Create successful');
    }

    /** @test */
    public function it_errors_creating_the_product_when_the_required_fields_are_not_filled()
    {
        $this
            ->actingAs($this->employee, 'employee')
            ->post(route('admin.products.store'), [])
            ->assertStatus(302)
            ->assertSessionHasErrors();
    }

    /** @test */
    public function it_can_detach_the_categories_associated_with_the_product()
    {
        $product = 'apple';

        $data = [
            'sku' => $this->faker->numberBetween(1111111, 999999),
            'name' => $product,
            'slug' => str_slug($product),
            'description' => $this->faker->paragraph,
            'cover' => UploadedFile::fake()->image('file.png', 200, 200),
            'quantity' => 10,
            'price' => 9.95,
            'status' => 1
        ];

        $this->actingAs($this->employee, 'employee')
            ->put(route('admin.products.update', $this->product->id), $data)
            ->assertSessionHas(['message' => 'Update successful'])
            ->assertRedirect(route('admin.products.edit', $this->product->id));
    }
    
    /** @test */
    public function it_can_sync_the_categories_associated_with_the_product()
    {
        $categories = [];

        $cats = factory(Category::class)->create();

        foreach ($cats as $cat) {
            $categories[] = $cat['id'];
        }

        $product = 'apple';

        $params = [
            'sku' => $this->faker->numberBetween(1111111, 999999),
            'name' => $product,
            'slug' => str_slug($product),
            'description' => $this->faker->paragraph,
            'cover' => UploadedFile::fake()->image('file.png', 200, 200),
            'quantity' => 10,
            'price' => 9.95,
            'status' => 1,
            'categories' => $categories
        ];

        $this->actingAs($this->employee, 'employee')
            ->put(route('admin.products.update', $this->product->id), $params)
            ->assertStatus(302)
            ->assertRedirect(route('admin.products.edit', $this->product->id))
            ->assertSessionHas('message', 'Update successful');
    }
}

<?php

namespace Tests\Feature;

use App\Shop\Categories\Category;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use Tests\TestCase;

class ProductFeatureTest extends TestCase
{
    /** @test */
    public function it_can_detach_all_the_categories()
    {
        $product = factory(Product::class)->create();
        $categories = factory(Category::class, 4)->create();

        $productRepo = new ProductRepository($product);

        $ids = [];
        foreach ($categories as $category) {
            $ids[] = $category->id;
        }

        $productRepo->syncCategories($ids);

        $this->assertCount(4, $productRepo->getCategories());

        $productRepo->detachCategories($product);

        $this->assertCount(0, $productRepo->getCategories());
    }

    /** @test */
    public function it_errors_creating_the_product_when_the_required_fields_are_not_filled()
    {
        $this
            ->actingAs($this->employee, 'admin')
            ->post(route('admin.products.store'), [])
            ->assertStatus(302)
            ->assertSessionHasErrors();
    }

    /** @test */
    public function it_can_detach_the_categories_associated_with_the_product()
    {
        $product = 'apple';

        $params = [
            'sku' => $this->faker->numberBetween(1111111, 999999),
            'name' => $product,
            'slug' => str_slug($product),
            'description' => $this->faker->paragraph,
            'cover' => null,
            'quantity' => 10,
            'price' => 9.95,
            'status' => 1,
            'categories' => []
        ];

        $this->actingAs($this->employee, 'admin')
            ->put(route('admin.products.update', $this->product->id), $params)
            ->assertSessionHas(['message'])
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
            'cover' => null,
            'quantity' => 10,
            'price' => 9.95,
            'status' => 1,
            'categories' => $categories
        ];

        $this->actingAs($this->employee, 'admin')
            ->put(route('admin.products.update', $this->product->id), $params)
            ->assertSessionHas(['message'])
            ->assertRedirect(route('admin.products.edit', $this->product->id));
    }
}

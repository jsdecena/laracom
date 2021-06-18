<?php

namespace Tests\Feature\Front\Categories;

use App\Shop\Categories\Category;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use Illuminate\Support\Str;
use Tests\TestCase;

class FrontCategoryFeatureTest extends TestCase
{
    /** @test */
    public function it_can_show_the_categories_and_products_associated_with_it()
    {
        $category = factory(Category::class)->create();
        $product = factory(Product::class)->create();

        $productRepo = new ProductRepository($product);
        $productRepo->syncCategories([$category->id]);

        $this
            ->get(route('front.category.slug', Str::slug($category->name)))
            ->assertStatus(200)
            ->assertSee($category->name)
            ->assertSee($product->name)
            ->assertSee($product->description)
            ->assertSee("$product->quantity")
            ->assertSee("$product->price");
    }
}

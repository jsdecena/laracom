<?php

namespace Tests\Unit\Categories;

use App\Categories\Category;
use App\Categories\Exceptions\CategoryInvalidArgumentException;
use App\Categories\Exceptions\CategoryNotFoundException;
use App\Categories\Repositories\CategoryRepository;
use Tests\TestCase;

class CategoryUnitTest extends TestCase
{
    /** @test */
    public function it_can_get_the_child_categories()
    {
        $parent = factory(Category::class)->create();

        $child = factory(Category::class)->create([
            'parent_id' => $parent->id
        ]);

        $categoryRepo = new CategoryRepository($parent);
        $children = $categoryRepo->findChildren();

        foreach ($children as $c) {
            $this->assertInstanceOf(Category::class, $c);
            $this->assertEquals($child->id, $c->id);
        }
    }
    
    /** @test */
    public function it_can_get_the_parent_category()
    {
        $parent = factory(Category::class)->create();

        $child = factory(Category::class)->create([
            'parent_id' => $parent->id
        ]);

        $categoryRepo = new CategoryRepository($child);
        $found = $categoryRepo->findParentCategory();

        $this->assertInstanceOf(Category::class, $found);
        $this->assertEquals($parent->id, $child->parent_id);
    }

    /** @test */
    public function it_can_return_products_in_the_category()
    {
        $category = new CategoryRepository($this->category);
        $category->syncProducts([$this->product->id]);
        $products = $category->findProductsInCategory($this->category->id);

        foreach ($products as $product) {
            $this->assertEquals($this->product->id, $product->id);
        }
    }
    
    /** @test */
    public function it_errors_looking_for_the_category_if_the_slug_is_not_found()
    {
        $this->expectException(CategoryNotFoundException::class);

        $category = new CategoryRepository($this->category);
        $category->findCategoryBySlug(['slug' => 'unknown']);
    }
    
    /** @test */
    public function it_can_get_the_category_by_slug()
    {
        $category = new CategoryRepository($this->category);
        $cat = $category->findCategoryBySlug(['slug' => $this->category->slug]);

        $this->assertEquals($this->category->name, $cat->name);
    }

    /** @test */
    public function it_can_delete_file_only_in_the_database()
    {
        $category = new CategoryRepository($this->category);
        $category->deleteFile(['category' => $this->category->id]);

        $this->assertDatabaseHas('categories', ['cover' => null]);
    }
    
    /** @test */
    public function it_can_detach_the_products()
    {
        $category = new CategoryRepository($this->category);
        $category->syncProducts([$this->product->id]);
        $category->detachProducts();

        $products = $category->findProducts();

        foreach ($products as $product) {
            $this->assertNotEquals($this->product->name, $product->name);
        }

    }

    /** @test */
    public function it_can_sync_products_in_the_category()
    {
        $category = new CategoryRepository($this->category);
        $category->syncProducts([$this->product->id]);

        $products = $category->findProducts();

        foreach ($products as $product) {
            $this->assertEquals($this->product->name, $product->name);
        }
    }


    /** @test */
    public function it_errors_creating_the_category_when_required_fields_are_not_passed()
    {
        $this->expectException(CategoryInvalidArgumentException::class);

        $product = new CategoryRepository(new Category);
        $product->createCategory([]);
    }

    /** @test */
    public function it_can_delete_a_category()
    {
        $category = new CategoryRepository($this->category);
        $category->deleteCategory();

        $this->assertDatabaseMissing('categories', collect($this->category)->all());
    }

    /** @test */
    public function it_can_list_all_the_categories()
    {
        $category = new CategoryRepository(new Category);
        $list = $category->listCategories();

        $this->arrayHasKey(array_keys($list->all()));
    }

    /** @test */
    public function it_errors_finding_a_category()
    {
        $this->expectException(CategoryNotFoundException::class);
        $this->expectExceptionMessage('Category not found.');

        $category = new CategoryRepository(new Category);
        $category->findCategoryById(999);
    }

    /** @test */
    public function it_can_find_the_category()
    {
        $category = new CategoryRepository(new Category);
        $found = $category->findCategoryById($this->category->id);

        $this->assertEquals($this->category->name, $found->name);
        $this->assertEquals($this->category->slug, $found->slug);
        $this->assertEquals($this->category->description, $found->description);
        $this->assertEquals($this->category->cover, $found->cover);
        $this->assertEquals($this->category->status, $found->status);
    }

    /** @test */
    public function it_can_update_the_category()
    {
        $params = [
            'name' => 'Boys',
            'slug' => 'boys',
            'description' => $this->faker->paragraph,
            'status' => 1
        ];

        $category = new CategoryRepository($this->category);
        $updated = $category->updateCategory($params);

        $this->assertInstanceOf(Category::class, $updated);
        $this->assertEquals($params['name'], $updated->name);
        $this->assertEquals($params['slug'], $updated->slug);
        $this->assertEquals($params['description'], $updated->description);
        $this->assertEquals($params['status'], $updated->status);

        $this->assertDatabaseHas('categories', $params);
    }

    /** @test */
    public function it_can_create_a_category()
    {
        $params = [
            'name' => 'Boys',
            'slug' => 'boys',
            'description' => $this->faker->paragraph,
            'status' => 1
        ];

        $category = new CategoryRepository(new Category);
        $created = $category->createCategory($params);

        $this->assertInstanceOf(Category::class, $created);
        $this->assertEquals($params['name'], $created->name);
        $this->assertEquals($params['slug'], $created->slug);
        $this->assertEquals($params['description'], $created->description);
        $this->assertEquals($params['status'], $created->status);

        $this->assertDatabaseHas('categories', $params);
    }
}
<?php

namespace Tests\Feature\Admin\Attributes;

use App\Shop\Attributes\Attribute;
use App\Shop\AttributeValues\AttributeValue;
use App\Shop\AttributeValues\Repositories\AttributeValueRepository;
use App\Shop\ProductAttributes\ProductAttribute;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\ProductRepository;
use Tests\TestCase;

class AttributesFeatureTest extends TestCase
{
    /** @test */
    public function it_can_update_product_attribute_combination()
    {
        $product = factory(Product::class)->create();

        $attributeValue1 = new AttributeValue(['value' => 'small']);
        $attributeValueRepo1 = new AttributeValueRepository($attributeValue1);

        $attribute1 = factory(Attribute::class)->create(['name' => 'Sizes']);
        $createdValue = $attributeValueRepo1->associateToAttribute($attribute1);

        $data = [
            'price' => 0,
            'quantity' => 0,
            'sku' => $this->faker->uuid,
            'name' => 'test',
            'productAttributeQuantity' => 1,
            'productAttributePrice' => 2.45,
            'attributeValue' => [$createdValue->id],
            'combination' => 1
        ];

        $this
            ->actingAs($this->employee, 'employee')
            ->put(route('admin.products.update', $product->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.products.edit', [$product->id, 'combination' => 1]))
            ->assertSessionHas('message', 'Attribute combination created successful');
    }

    /** @test */
    public function it_can_detach_the_attribute_from_the_product_and_delete_it()
    {
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
        $productRepo->saveCombination($created, $createdValue1, $createdValue2);

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.products.edit', [$product->id, 'delete' => 1, 'pa' => $created->id]))
            ->assertStatus(302)
            ->assertRedirect(route('admin.products.edit', [$product->id, 'combination' => 1]))
            ->assertSessionHas('message', 'Delete successful');
    }

    /** @test */
    public function it_error_when_the_attribute_is_not_found()
    {
        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.attributes.show', 999))
            ->assertStatus(302)
            ->assertRedirect(route('admin.attributes.index'))
            ->assertSessionHas('error', 'The attribute you are looking for is not found.');
    }

    /** @test */
    public function it_can_show_the_attribute()
    {
        $attribute = factory(Attribute::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.attributes.show', $attribute->id))
            ->assertStatus(200)
            ->assertSee('Attribute name')
            ->assertSee('Back');
    }

    /** @test */
    public function it_can_delete_the_attribute()
    {
        $attribute = factory(Attribute::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->delete(route('admin.attributes.destroy', $attribute->id))
            ->assertStatus(302)
            ->assertRedirect(route('admin.attributes.index'))
            ->assertSessionHas('message', 'Attribute deleted successfully!');
    }

    /** @test */
    public function it_should_be_able_to_create_an_attribute()
    {
        $data = [
            'name' => $this->faker->word
        ];

        $this
            ->actingAs($this->employee, 'employee')
            ->post(route('admin.attributes.store'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.attributes.edit', 1));
    }

    /** @test */
    public function it_should_show_the_create_attribute_page()
    {
        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.attributes.create'))
            ->assertStatus(200)
            ->assertSee('Attribute name')
            ->assertSee('Create')
            ->assertSee('Back');
    }

    /** @test */
    public function it_errors_updating_the_attribute()
    {
        $attribute = factory(Attribute::class)->create();

        $data = ['name' => null];

        $this
            ->actingAs($this->employee, 'employee')
            ->put(route('admin.attributes.update', $attribute->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.attributes.edit', $attribute->id))
            ->assertSessionHas('error');
    }

    /** @test */
    public function it_should_be_able_to_update_the_attribute()
    {
        $attribute = factory(Attribute::class)->create();

        $data = [
            'name' => $this->faker->word
        ];

        $this
            ->actingAs($this->employee, 'employee')
            ->put(route('admin.attributes.update', $attribute->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.attributes.edit', $attribute->id))
            ->assertSessionHas('message', 'Attribute update successful!');
    }

    /** @test */
    public function it_should_show_the_update_attribute_page()
    {
        $attribute = factory(Attribute::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.attributes.edit', $attribute->id))
            ->assertStatus(200)
            ->assertSee('Attribute name')
            ->assertSee('Update')
            ->assertSee('Back');
    }

    /** @test */
    public function it_should_show_the_list_of_attributes_page()
    {
        factory(Attribute::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.attributes.index'))
            ->assertStatus(200)
            ->assertSee('Attribute name')
            ->assertSee('Edit')
            ->assertSee('Delete');
    }
}

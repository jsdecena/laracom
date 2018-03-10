<?php

namespace Tests\Feature\Admin\Attributes;

use App\Shop\Attributes\Attribute;
use Tests\TestCase;

class AttributesFeatureTest extends TestCase
{
    /** @test */
    public function it_can_show_the_attribute()
    {
        $attribute = factory(Attribute::class)->create();

        $this
            ->actingAs($this->employee, 'admin')
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
            ->actingAs($this->employee, 'admin')
            ->delete(route('admin.attributes.destroy', $attribute->id))
            ->assertStatus(302)
            ->assertRedirect(route('admin.attributes.index'))
            ->assertSessionHas('message', 'Attribute deleted successfully!');
    }

    /** @test */
    public function it_should_be_able_to_create_an_attribute()
    {
        $data = [
            'name' => $this->faker->word,
            'value' => $this->faker->word
        ];

        $this
            ->actingAs($this->employee, 'admin')
            ->post(route('admin.attributes.store'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.attributes.edit', 1));
    }

    /** @test */
    public function it_should_show_the_create_attribute_page()
    {
        $this
            ->actingAs($this->employee, 'admin')
            ->get(route('admin.attributes.create'))
            ->assertStatus(200)
            ->assertSee('Attribute name')
            ->assertSee('Create')
            ->assertSee('Back');
    }

    /** @test */
    public function it_should_be_able_to_update_the_attribute()
    {
        $attribute = factory(Attribute::class)->create();

        $data = [
            'name' => $this->faker->word,
            'value' => $this->faker->word
        ];

        $this
            ->actingAs($this->employee, 'admin')
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
            ->actingAs($this->employee, 'admin')
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
            ->actingAs($this->employee, 'admin')
            ->get(route('admin.attributes.index'))
            ->assertStatus(200)
            ->assertSee('Attribute name')
            ->assertSee('Edit')
            ->assertSee('Delete');
    }
}
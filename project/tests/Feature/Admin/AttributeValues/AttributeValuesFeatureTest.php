<?php

namespace Tests\Feature\Admin\AttributeValues;

use App\Shop\Attributes\Attribute;
use Tests\TestCase;

class AttributeValuesFeatureTest extends TestCase
{
    /** @test */
    public function it_can_remove_the_attribute_value()
    {
        $attribute = factory(Attribute::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->post(route('admin.attributes.values.store', $attribute->id), ['value' => 'test']);

        $this
            ->actingAs($this->employee, 'employee')
            ->delete(route('admin.attributes.values.destroy', [$attribute->id, 1]))
            ->assertStatus(302)
            ->assertRedirect(route('admin.attributes.show', $attribute->id))
            ->assertSessionHas('message', 'Attribute value removed!');
    }

    /** @test */
    public function it_can_store_the_attribute_values()
    {
        $attribute = factory(Attribute::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->post(route('admin.attributes.values.store', $attribute->id), ['value' => 'test'])
            ->assertStatus(302)
            ->assertRedirect(route('admin.attributes.show', $attribute->id))
            ->assertSessionHas('message', 'Attribute value created');
    }
    
    /** @test */
    public function it_can_sow_the_create_the_attribute_value_page()
    {
        $attribute = factory(Attribute::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.attributes.values.create', $attribute->id))
            ->assertStatus(200)
            ->assertSee('Attribute value')
            ->assertSee($attribute->name);
    }
}

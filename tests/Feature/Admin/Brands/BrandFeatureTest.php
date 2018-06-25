<?php

namespace Tests\Feature\Admin\Brands;

use App\Shop\Brands\Brand;
use Tests\TestCase;

class BrandFeatureTest extends TestCase
{
    /** @test */
    public function it_can_delete_the_brand()
    {
        $brand = factory(Brand::class)->create();

        $this->actingAs($this->employee, 'employee')
            ->delete(route('admin.brands.destroy', $brand->id), [])
            ->assertStatus(302)
            ->assertRedirect(route('admin.brands.index'))
            ->assertSessionHas(['message' => 'Delete successful!']);
    }
    
    /** @test */
    public function it_can_update_the_brand()
    {
        $brand = factory(Brand::class)->create();

        $data = ['name' => 'Hello Panda!'];

        $this->actingAs($this->employee, 'employee')
            ->put(route('admin.brands.update', $brand->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.brands.edit', $brand->id))
            ->assertSessionHas(['message' => 'Update successful!']);
    }
    
    /** @test */
    public function it_can_show_the_edit_brand_form()
    {
        $brand = factory(Brand::class)->create();

        $this->actingAs($this->employee, 'employee')
            ->get(route('admin.brands.edit', $brand->id))
            ->assertStatus(200)
            ->assertSee($brand->name);
    }
    
    /** @test */
    public function it_can_list_all_the_brands()
    {
        $brand = factory(Brand::class)->create();

        $this->actingAs($this->employee, 'employee')
            ->get(route('admin.brands.index'))
            ->assertStatus(200)
            ->assertSee(htmlentities($brand->name, ENT_QUOTES));
    }
    
    /** @test */
    public function it_can_create_the_brand()
    {
        $this->actingAs($this->employee, 'employee')
            ->post(route('admin.brands.store'), ['name' => $this->faker->company])
            ->assertStatus(302)
            ->assertRedirect(route('admin.brands.index'))
            ->assertSessionHas(['message' => 'Create brand successful!']);
    }
    
    /** @test */
    public function it_can_see_the_brand_create_form()
    {
        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.brands.create'))
            ->assertSee('Name')
            ->assertSee('Create')
            ->assertSee('Back')
            ->assertStatus(200);
    }
}

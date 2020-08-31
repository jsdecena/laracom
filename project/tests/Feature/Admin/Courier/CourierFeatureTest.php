<?php

namespace Tests\Feature;

use App\Shop\Couriers\Courier;
use Tests\TestCase;

class CourierFeatureTest extends TestCase
{
    /** @test */
    public function it_can_list_all_couriers()
    {
        $courier = factory(Courier::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.couriers.index'))
            ->assertStatus(200)
            ->assertSee(htmlentities($courier->name, ENT_QUOTES));
    }
    
    /** @test */
    public function it_can_delete_the_courier()
    {
        $courier = factory(Courier::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->delete(route('admin.couriers.destroy', $courier->id))
            ->assertStatus(302)
            ->assertRedirect(route('admin.couriers.index'))
            ->assertSessionHas('message', 'Delete successful');
    }
    
    /** @test */
    public function it_can_update_the_courier()
    {
        $courier = factory(Courier::class)->create();

        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->sentence,
            'is_free' => 1,
            'status' => 1
        ];

        $this
            ->actingAs($this->employee, 'employee')
            ->put(route('admin.couriers.update', $courier->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.couriers.edit', $courier->id))
            ->assertSessionHas('message', 'Update successful');
    }

    /** @test */
    public function it_can_show_the_edit_page()
    {
        $courier = factory(Courier::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.couriers.edit', $courier->id))
            ->assertStatus(200)
            ->assertSee(htmlentities($courier->name, ENT_QUOTES));
    }
    
    /** @test */
    public function it_can_show_the_create_page()
    {
        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.couriers.create'))
            ->assertStatus(200);
    }
    
    /** @test */
    public function it_can_create_courier()
    {
        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->sentence,
            'is_free' => 1,
            'status' => 1
        ];

        $this
            ->actingAs($this->employee, 'employee')
            ->post(route('admin.couriers.store'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.couriers.index'))
            ->assertSessionHas('message', 'Create successful');
    }

    /** @test */
    public function it_errors_updating_the_courier()
    {
        $courier = factory(Courier::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->put(route('admin.couriers.update', $courier->id), [])
            ->assertSessionHasErrors(['name' => 'The name field is required.']);
    }

    /** @test */
    public function it_errors_creating_the_courier_with_the_name_already_existing()
    {
        $courier = factory(Courier::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->post(route('admin.couriers.store'), ['name' => $courier->name])
            ->assertSessionHasErrors();
    }
    
    /** @test */
    public function it_errors_creating_the_courier()
    {
        $this
            ->actingAs($this->employee, 'employee')
            ->post(route('admin.couriers.store'), [])
            ->assertSessionHasErrors(['name' => 'The name field is required.']);
    }
}

<?php

namespace Tests\Feature\Admin\OrderStatus;

use App\Shop\OrderStatuses\OrderStatus;
use Tests\TestCase;

class OrderStatusFeatureTest extends TestCase
{
    /** @test */
    public function it_can_delete_the_order_status()
    {
        $os = factory(OrderStatus::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->delete(route('admin.order-statuses.destroy', $os->id))
            ->assertStatus(302)
            ->assertRedirect(route('admin.order-statuses.index'))
            ->assertSessionHas('message', 'Delete successful');
    }

    /** @test */
    public function it_can_update_the_order_status()
    {
        $os = factory(OrderStatus::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->put(route('admin.order-statuses.update', $os->id), ['name' => 'test'])
            ->assertStatus(302)
            ->assertRedirect(route('admin.order-statuses.edit', $os->id))
            ->assertSessionHas('message', 'Update successful');
    }
    
    /** @test */
    public function it_can_show_the_create_and_edit_form_of_the_order_status()
    {
        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.order-statuses.create'))
            ->assertStatus(200);

        $os = factory(OrderStatus::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.order-statuses.edit', $os->id))
            ->assertStatus(200)
            ->assertSee($os->name)
            ->assertSee($os->color);
    }
    
    /** @test */
    public function it_can_create_order_status()
    {
        $create = [
            'name' => $this->faker->name,
            'color' => $this->faker->word
        ];

        $this
            ->actingAs($this->employee, 'employee')
            ->post(route('admin.order-statuses.store'), $create)
            ->assertStatus(302)
            ->assertRedirect(route('admin.order-statuses.index'))
            ->assertSessionHas('message', 'Create successful');
    }
    
    /** @test */
    public function it_can_show_all_the_order_statues()
    {
        factory(OrderStatus::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.order-statuses.index'))
            ->assertStatus(200);
    }
    
    /** @test */
    public function it_errors_when_the_order_status_being_updated_is_already_existing()
    {
        $os = factory(OrderStatus::class)->create();
        $os2 = factory(OrderStatus::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->put(route('admin.order-statuses.update', $os->id), ['name' => $os2->name])
            ->assertStatus(302)
            ->assertSessionHasErrors(['name' => 'The name has already been taken.']);
    }

    /** @test */
    public function it_errors_when_the_order_status_being_updated_is_null()
    {
        $os = factory(OrderStatus::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->put(route('admin.order-statuses.update', $os->id), ['name' => null])
            ->assertStatus(302)
            ->assertSessionHasErrors(['name' => 'The name field is required.']);
    }
    
    /** @test */
    public function it_errors_when_name_of_the_order_status_is_not_filled()
    {
        $this
            ->actingAs($this->employee, 'employee')
            ->post(route('admin.order-statuses.store', []))
            ->assertStatus(302)
            ->assertSessionHasErrors(['name' => 'The name field is required.']);
    }
}

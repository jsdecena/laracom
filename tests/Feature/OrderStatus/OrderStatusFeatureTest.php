<?php

namespace Tests\Feature\OrderStatus;

use App\Shop\OrderStatuses\OrderStatus;
use Tests\TestCase;

class OrderStatusFeatureTest extends TestCase
{
    /** @test */
    public function it_errors_when_the_order_status_being_updated_is_already_existing()
    {
        $os = factory(OrderStatus::class)->create();
        $os2 = factory(OrderStatus::class)->create();

        $this
            ->actingAs($this->employee, 'admin')
            ->put(route('admin.order-statuses.update', $os->id), ['name' => $os2->name])
            ->assertStatus(302)
            ->assertSessionHasErrors(['name' => 'The name has already been taken.']);
    }

    /** @test */
    public function it_errors_when_the_order_status_being_updated_is_null()
    {
        $os = factory(OrderStatus::class)->create();

        $this
            ->actingAs($this->employee, 'admin')
            ->put(route('admin.order-statuses.update', $os->id), ['name' => null])
            ->assertStatus(302)
            ->assertSessionHasErrors(['name' => 'The name field is required.']);
    }
    
    /** @test */
    public function it_errors_when_name_of_the_order_status_is_not_filled()
    {
        $this
            ->actingAs($this->employee, 'admin')
            ->post(route('admin.order-statuses.store', []))
            ->assertStatus(302)
            ->assertSessionHasErrors(['name' => 'The name field is required.']);
    }
}

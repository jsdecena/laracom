<?php

namespace Tests\Feature;

use App\Shop\Couriers\Courier;
use Tests\TestCase;

class CourierFeatureTest extends TestCase
{
    /** @test */
    public function it_errors_updating_the_courier()
    {
        $courier = factory(Courier::class)->create();

        $this
            ->actingAs($this->employee, 'admin')
            ->put(route('admin.couriers.update', $courier->id), [])
            ->assertSessionHasErrors(['name' => 'The name field is required.']);
    }

    /** @test */
    public function it_errors_creating_the_courier_with_the_name_already_existing()
    {
        $courier = factory(Courier::class)->create();

        $this
            ->actingAs($this->employee, 'admin')
            ->post(route('admin.couriers.store'), ['name' => $courier->name])
            ->assertSessionHasErrors();
    }
    
    /** @test */
    public function it_errors_creating_the_courier()
    {
        $this
            ->actingAs($this->employee, 'admin')
            ->post(route('admin.couriers.store'), [])
            ->assertSessionHasErrors(['name' => 'The name field is required.']);
    }
}
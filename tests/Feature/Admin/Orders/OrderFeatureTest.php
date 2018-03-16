<?php

namespace Tests\Feature\Admin\Orders;

use App\Shop\Addresses\Address;
use App\Shop\Cities\City;
use App\Shop\Couriers\Courier;
use App\Shop\Customers\Customer;
use App\Shop\Orders\Order;
use Tests\TestCase;

class OrderFeatureTest extends TestCase
{
    /** @test */
    public function it_can_search_for_the_order()
    {
        factory(Courier::class)->create();
        factory(City::class)->create();
        factory(Address::class)->create();
        $customer = factory(Customer::class)->create();
        factory(Order::class)->create([
            'customer_id' => $customer->id
        ]);

        $this
            ->actingAs($this->employee, 'admin')
            ->get(route('admin.orders.index', ['q' => str_limit($customer->name, 5, '')]))
            ->assertStatus(200)
            ->assertSee($customer->name);
    }
    
    /** @test */
    public function it_can_show_the_order()
    {
        factory(Courier::class)->create();
        factory(City::class)->create();
        factory(Address::class)->create();
        $order = factory(Order::class)->create();

        $this
            ->actingAs($this->employee, 'admin')
            ->get(route('admin.orders.show', $order->id))
            ->assertStatus(200)
            ->assertSee($order->reference);
    }

    /** @test */
    public function it_can_list_all_the_orders()
    {
        $this
            ->actingAs($this->employee, 'admin')
            ->get(route('admin.orders.index'))
            ->assertStatus(200);
    }
}

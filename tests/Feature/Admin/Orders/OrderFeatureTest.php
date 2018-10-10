<?php

namespace Tests\Feature\Admin\Orders;

use App\Shop\Customers\Customer;
use App\Shop\Orders\Order;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\Products\Product;
use Tests\TestCase;

class OrderFeatureTest extends TestCase
{
    /** @test */
    public function it_can_search_for_the_order()
    {
        $customer = factory(Customer::class)->create();
        factory(Order::class)->create([
            'customer_id' => $customer->id
        ]);

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.orders.index', ['q' => str_limit($customer->name, 5, '')]))
            ->assertStatus(200)
            ->assertSee($customer->name);
    }
    
    /** @test */
    public function it_can_show_the_order()
    {
        $order = factory(Order::class)->create();

        $product = factory(Product::class)->create();

        $orderRepo = new OrderRepository($order);
        $orderRepo->associateProduct($product);

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.orders.show', $order->id))
            ->assertStatus(200)
            ->assertSee($order->reference)
            ->assertSee('SKU')
            ->assertSee('Name')
            ->assertSee('Description')
            ->assertSee('Quantity')
            ->assertSee('Price');
    }

    /** @test */
    public function it_can_list_all_the_orders()
    {
        factory(Order::class)->create();

        $this
            ->actingAs($this->employee, 'employee')
            ->get(route('admin.orders.index'))
            ->assertStatus(200);
    }
}

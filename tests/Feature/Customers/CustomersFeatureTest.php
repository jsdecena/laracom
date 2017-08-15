<?php

namespace Tests\Feature;

use App\Customers\Customer;
use Tests\TestCase;

class CustomersFeatureTest extends TestCase
{
    /** @test */
    public function it_can_update_the_customers_password()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'unknown'
        ];

        $this->actingAs($this->employee, 'admin')
            ->put(route('customers.update', $this->customer->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('customers.edit', $this->customer->id));
    }

    /** @test */
    public function it_can_show_all_the_customers()
    {
        factory(Customer::class, 20)->create();

        $this->actingAs($this->employee, 'admin')
            ->get(route('customers.index'))
            ->assertViewHas(['customers']);
    }
    
    /** @test */
    public function it_can_show_the_customer()
    {
        $this->actingAs($this->employee, 'admin')
            ->get(route('customers.show', $this->customer->id))
            ->assertViewHas(['customer'])
            ->assertSeeText($this->customer->name);
    }
    
    /** @test */
    public function it_can_update_the_customer()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email
        ];

        $this->actingAs($this->employee, 'admin')
            ->put(route('customers.update', $this->customer->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('customers.edit', $this->customer->id));

        $this->assertDatabaseHas('customers', $data);
    }

    /** @test */
    public function it_can_create_an_employee()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'secret!!'
        ];

        $this->actingAs($this->employee, 'admin')
            ->post(route('customers.store'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('customers.index'));

        $created = collect($data)->except('password');

        $this->assertDatabaseHas('customers', $created->all());
    }
}

<?php

namespace Tests\Feature;

use App\Customers\Customer;
use Tests\TestCase;

class CustomersFeatureTest extends TestCase
{
    /** @test */
    public function it_errors_when_sending_an_inquiry_and_required_fields_are_not_set()
    {
        $this
            ->post(route('inquiry.store'), [])
            ->assertSessionHasErrors([
                'email' => 'The email field is required.',
                'first_name' => 'The first name field is required.',
                'last_name' => 'The last name field is required.'
            ]);
    }
    
    /** @test */
    public function it_errors_when_the_customer_is_logging_in_without_the_email_or_password()
    {
        $this
            ->post('login', [])
            ->assertSessionHasErrors([
                'email' => 'The email field is required.',
                'password' => 'The password field is required.'
            ]);
    }
    
    /** @test */
    public function it_can_update_the_customers_password()
    {
        $customer = factory(Customer::class)->create();

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'unknown'
        ];

        $this->actingAs($this->employee, 'admin')
            ->put(route('admin.customers.update', $customer->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.customers.edit', $customer->id));
    }

    /** @test */
    public function it_can_show_all_the_customers()
    {
        factory(Customer::class, 20)->create();

        $this->actingAs($this->employee, 'admin')
            ->get(route('admin.customers.index'))
            ->assertViewHas(['customers']);
    }
    
    /** @test */
    public function it_can_show_the_customer()
    {
        $customer = factory(Customer::class)->create();

        $this->actingAs($this->employee, 'admin')
            ->get(route('admin.customers.show', $customer->id))
            ->assertViewHas(['customer'])
            ->assertSeeText($customer->name);
    }
    
    /** @test */
    public function it_can_update_the_customer()
    {
        $customer = factory(Customer::class)->create();

        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email
        ];

        $this->actingAs($this->employee, 'admin')
            ->put(route('admin.customers.update', $customer->id), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.customers.edit', $customer->id));

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
            ->post(route('admin.customers.store'), $data)
            ->assertStatus(302)
            ->assertRedirect(route('admin.customers.index'));

        $created = collect($data)->except('password');

        $this->assertDatabaseHas('customers', $created->all());
    }
}

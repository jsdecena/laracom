<?php

namespace Tests\Unit\Customers;

use App\Addresses\Address;
use App\Customers\Customer;
use App\Customers\Exceptions\CustomerNotFoundException;
use App\Customers\Repositories\CustomerRepository;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CustomerUnitTest extends TestCase 
{
    /** @test */
    public function it_can_update_customers_password()
    {
        $cust = factory(Customer::class)->create();

        $customer = new CustomerRepository($cust);
        $customer->updateCustomer([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'status' => 1,
            'password' => 'unknown'
        ]);

        $this->assertTrue(Hash::check('unknown', bcrypt($cust->password)));
    }
    
    /** @test */
    public function it_can_retrieve_the_address_attached_to_the_customer()
    {
        $cust = factory(Customer::class)->create();
        $address = factory(Address::class)->create();

        $customerRepo = new CustomerRepository($cust);
        $customerRepo->attachAddress($address);

        $lists = $customerRepo->findAddresses();

        $this->assertCount(1, $lists);
    }
    
    /** @test */
    public function it_can_attach_the_address()
    {
        $cust = factory(Customer::class)->create();
        $address = factory(Address::class)->create();
        $customer = new CustomerRepository($cust);
        $attachedAddress = $customer->attachAddress($address);

        $this->assertEquals($address->alias, $attachedAddress->alias);
        $this->assertEquals($address->address_1, $attachedAddress->address_1);
    }
    
    /** @test */
    public function it_can_soft_delete_a_customer()
    {
        $customer = factory(Customer::class)->create();

        $customerRepo = new CustomerRepository($customer);
        $delete = $customerRepo->deleteCustomer();

        $this->assertTrue($delete);

        $this->assertDatabaseHas('customers', $customer->toArray());
    }

    /** @test */
    public function it_fails_when_the_customer_is_not_found()
    {
        $this->expectException(CustomerNotFoundException::class);
        $this->expectExceptionMessage('Customer not found.');

        $customer = new CustomerRepository(new Customer);
        $customer->findCustomerById(999);
    }

    /** @test */
    public function it_can_find_a_customer()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'secret'
        ];

        $customer = new CustomerRepository(new Customer);
        $created = $customer->createCustomer($data);

        $found = $customer->findCustomerById($created->id);

        $this->assertInstanceOf(Customer::class, $found);
        $this->assertEquals($data['name'], $found->name);
        $this->assertEquals($data['email'], $found->email);

    }
    
    /** @test */
    public function it_can_update_the_customer()
    {
        $cust = factory(Customer::class)->create();
        $customer = new CustomerRepository($cust);

        $update = [
            'name' => $this->faker->name,
        ];

        $updated = $customer->updateCustomer($update);

        $this->assertTrue($updated);
        $this->assertEquals($update['name'], $cust->name);
        $this->assertDatabaseHas('customers', $update);
    }

    /** @test */
    public function it_can_create_a_customer()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => 'secret'
        ];

        $customer = new CustomerRepository(new Customer);
        $created = $customer->createCustomer($data);

        $this->assertInstanceOf(Customer::class, $created);
        $this->assertEquals($data['name'], $created->name);
        $this->assertEquals($data['email'], $created->email);

        $collection = collect($data)->except('password');

        $this->assertDatabaseHas('customers', $collection->all());
    }
}
<?php

namespace Tests\Unit\Customers;

use App\Shop\Addresses\Address;
use App\Shop\Customers\Customer;
use App\Shop\Customers\Exceptions\CreateCustomerInvalidArgumentException;
use App\Shop\Customers\Exceptions\CustomerNotFoundException;
use App\Shop\Customers\Exceptions\UpdateCustomerInvalidArgumentException;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Transformations\CustomerTransformable;
use App\Shop\Orders\Order;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CustomerUnitTest extends TestCase
{
    use CustomerTransformable;
    
    /** @test */
    public function it_can_search_for_customers()
    {
        $name = $this->faker->name;
        $customer = factory(Customer::class)->create([
            'name' => $name,
            'email' => $this->faker->email
        ]);

        $repo = new CustomerRepository($customer);
        $result = $repo->searchCustomer($name);

        $this->assertGreaterThan(0, $result->count());
    }
    
    /** @test */
    public function it_can_return_all_the_orders_of_the_customer()
    {
        $customer = factory(Customer::class)->create();

        $order = factory(Order::class)->create([
            'customer_id' => $customer->id
        ]);

        $repo = new CustomerRepository($customer);
        $orders = $repo->findOrders();

        $this->assertInstanceOf(Collection::class, $orders);

        foreach ($orders as $o) {
            $this->assertEquals($order->id, $o->id);
            $this->assertEquals($customer->id, $o->customer_id);
        }
    }

    /** @test */
    public function it_can_transform_the_customer()
    {
        $customer = factory(Customer::class)->create();

        $repo = new CustomerRepository($customer);

        $customerFromDb = $repo->findCustomerById($customer->id);
        $cust = $this->transformCustomer($customer);

        $this->assertInternalType('string', $customerFromDb->status);
        $this->assertInternalType('int', $cust->status);
    }
    
    /** @test */
    public function it_errors_updating_the_customer_name_with_null_value()
    {
        $this->expectException(UpdateCustomerInvalidArgumentException::class);

        $cust = factory(Customer::class)->create();

        $customer = new CustomerRepository($cust);
        $customer->updateCustomer(['name' => null]);
    }

    /** @test */
    public function it_errors_creating_the_customer()
    {
        $this->expectException(CreateCustomerInvalidArgumentException::class);
        $this->expectExceptionCode(500);

        $customer = new CustomerRepository(new Customer);
        $customer->createCustomer([]);
    }

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

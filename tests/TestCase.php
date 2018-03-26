<?php

namespace Tests;

use App\Shop\Addresses\Address;
use App\Shop\Categories\Category;
use App\Shop\Couriers\Courier;
use App\Shop\Couriers\Repositories\CourierRepository;
use App\Shop\Employees\Employee;
use App\Shop\Customers\Customer;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;
use App\Shop\Products\Product;
use App\Shop\Roles\Repositories\RoleRepository;
use App\Shop\Roles\Role;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory as Faker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseMigrations, DatabaseTransactions;

    protected $faker;
    protected $employee;
    protected $customer;
    protected $address;
    protected $product;
    protected $category;
    protected $country;
    protected $province;
    protected $city;
    protected $courier;
    protected $orderStatus;
    protected $cart;

    /**
     * Set up the test
     */
    public function setUp()
    {
        parent::setUp();

        $this->faker = Faker::create();
        $this->employee = factory(Employee::class)->create();

        $adminData = ['name' => 'admin'];

        $roleRepo = new RoleRepository(new Role);
        $admin = $roleRepo->createRole($adminData);

        $employeeRepo = new EmployeeRepository($this->employee);
        $employeeRepo->syncRoles([$admin->id]);

        $this->product = factory(Product::class)->create();
        $this->category = factory(Category::class)->create();
        $this->customer = factory(Customer::class)->create();

        $this->address = factory(Address::class)->create();

        $courierData = [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'url' => $this->faker->sentence,
            'is_free' => 1,
            'status' => 1
        ];

        $courierRepo = new CourierRepository(new Courier);
        $this->courier = $courierRepo->createCourier($courierData);

        $orderStatusData = [
            'name' => $this->faker->name,
            'color' => $this->faker->word
        ];

        $orderStatusRepo = new OrderStatusRepository(new OrderStatus);
        $this->orderStatus = $orderStatusRepo->createOrderStatus($orderStatusData);

        $session = $this->app->make('session');
        $events = $this->app->make('events');
        $this->cart = new Cart($session, $events);
    }

    public function tearDown()
    {
        $this->artisan('migrate:reset');
        parent::tearDown();
    }
}

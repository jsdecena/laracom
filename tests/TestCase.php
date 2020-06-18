<?php

namespace Tests;

use App\Shop\Addresses\Address;
use App\Shop\Categories\Category;
use App\Shop\Countries\Country;
use App\Shop\Couriers\Courier;
use App\Shop\Couriers\Repositories\CourierRepository;
use App\Shop\Employees\Employee;
use App\Shop\Customers\Customer;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;
use App\Shop\Permissions\Permission;
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
    protected $role;

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
        $this->role = $admin;

        $createProductPerm = factory(Permission::class)->create([
            'name' => 'create-product',
            'display_name' => 'Create product'
        ]);

        $viewProductPerm = factory(Permission::class)->create([
            'name' => 'view-product',
            'display_name' => 'View product'
        ]);

        $updateProductPerm = factory(Permission::class)->create([
            'name' => 'update-product',
            'display_name' => 'Update product'
        ]);

        $deleteProductPerm = factory(Permission::class)->create([
            'name' => 'delete-product',
            'display_name' => 'Delete product'
        ]);

        $roleSuperRepo = new RoleRepository($admin);
        $roleSuperRepo->attachToPermission($createProductPerm);
        $roleSuperRepo->attachToPermission($viewProductPerm);
        $roleSuperRepo->attachToPermission($updateProductPerm);
        $roleSuperRepo->attachToPermission($deleteProductPerm);

        $employeeRepo = new EmployeeRepository($this->employee);
        $employeeRepo->syncRoles([$admin->id]);

        $this->product = factory(Product::class)->create();
        $this->category = factory(Category::class)->create();
        $this->customer = factory(Customer::class)->create();

        $this->country = factory(Country::class)->create();

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

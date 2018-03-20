<?php

namespace Laracommerce\Core\Tests;

use Illuminate\Support\Facades\Config;
use Laracommerce\Core\Addresses\Address;
use Laracommerce\Core\Addresses\Repositories\AddressRepository;
use Laracommerce\Core\Categories\Category;
use Laracommerce\Core\Couriers\Courier;
use Laracommerce\Core\Couriers\Repositories\CourierRepository;
use Laracommerce\Core\Employees\Employee;
use Laracommerce\Core\Customers\Customer;
use Laracommerce\Core\Employees\Repositories\EmployeeRepository;
use Laracommerce\Core\OrderStatuses\OrderStatus;
use Laracommerce\Core\OrderStatuses\Repositories\OrderStatusRepository;
use Laracommerce\Core\Permissions\Permission;
use Laracommerce\Core\Products\Product;
use Laracommerce\Core\Providers\GlobalTemplateServiceProvider;
use Laracommerce\Core\Providers\RepositoryServiceProvider;
use Laracommerce\Core\Roles\Repositories\RoleRepository;
use Laracommerce\Core\Roles\Role;
use Gloudemans\Shoppingcart\Cart;
use Laracommerce\Core\Teams\Team;
use Laratrust\LaratrustServiceProvider;
use Laravel\Cashier\CashierServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Faker\Factory as Faker;

abstract class TestCase extends Orchestra
{
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

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->withFactories(__DIR__.'/../database/factories');

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

    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            LaratrustServiceProvider::class,
            GlobalTemplateServiceProvider::class,
            RepositoryServiceProvider::class,
            CashierServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application   $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('cache.default', 'array');
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('laratrust.user_models.users', Employee::class);
        $app['config']->set('laratrust.models', [
            'role' => Role::class,
            'permission' => Permission::class,
            'team' => Team::class,
        ]);
    }


}

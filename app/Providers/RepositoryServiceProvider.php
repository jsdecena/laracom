<?php

namespace App\Providers;

use App\Addresses\Repositories\AddressRepository;
use App\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Carts\Repositories\CartRepository;
use App\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Categories\Repositories\CategoryRepository;
use App\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Cities\Repositories\CityRepository;
use App\Cities\Repositories\Interfaces\CityRepositoryInterface;
use App\Countries\Repositories\CountryRepository;
use App\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use App\Couriers\Repositories\CourierRepository;
use App\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Customers\Repositories\CustomerRepository;
use App\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Employees\Repositories\EmployeeRepository;
use App\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Orders\Repositories\OrderRepository;
use App\OrderStatuses\Repositories\Interfaces\OrderStatusRepositoryInterface;
use App\OrderStatuses\Repositories\OrderStatusRepository;
use App\PaymentMethods\Repositories\Interfaces\PaymentMethodRepositoryInterface;
use App\PaymentMethods\Repositories\PaymentMethodRepository;
use App\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Products\Repositories\ProductRepository;
use App\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;
use App\Provinces\Repositories\ProvinceRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            EmployeeRepositoryInterface::class,
            EmployeeRepository::class
        );

        $this->app->bind(
            CustomerRepositoryInterface::class,
            CustomerRepository::class
        );

        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );

        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );

        $this->app->bind(
            AddressRepositoryInterface::class,
            AddressRepository::class
        );

        $this->app->bind(
            CountryRepositoryInterface::class,
            CountryRepository::class
        );

        $this->app->bind(
            ProvinceRepositoryInterface::class,
            ProvinceRepository::class
        );

        $this->app->bind(
            CityRepositoryInterface::class,
            CityRepository::class
        );

        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );

        $this->app->bind(
            OrderStatusRepositoryInterface::class,
            OrderStatusRepository::class
        );

        $this->app->bind(
            CourierRepositoryInterface::class,
            CourierRepository::class
        );

        $this->app->bind(
            PaymentMethodRepositoryInterface::class,
            PaymentMethodRepository::class
        );

        $this->app->bind(
            CartRepositoryInterface::class,
            CartRepository::class
        );
    }
}
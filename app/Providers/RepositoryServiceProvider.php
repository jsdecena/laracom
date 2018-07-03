<?php

namespace App\Providers;

use App\Shop\Addresses\Repositories\AddressRepository;
use App\Shop\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use App\Shop\Attributes\Repositories\AttributeRepository;
use App\Shop\Attributes\Repositories\AttributeRepositoryInterface;
use App\Shop\AttributeValues\Repositories\AttributeValueRepository;
use App\Shop\AttributeValues\Repositories\AttributeValueRepositoryInterface;
use App\Shop\Brands\Repositories\BrandRepository;
use App\Shop\Brands\Repositories\BrandRepositoryInterface;
use App\Shop\Carts\Repositories\CartRepository;
use App\Shop\Carts\Repositories\Interfaces\CartRepositoryInterface;
use App\Shop\Categories\Repositories\CategoryRepository;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Cities\Repositories\CityRepository;
use App\Shop\Cities\Repositories\Interfaces\CityRepositoryInterface;
use App\Shop\Countries\Repositories\CountryRepository;
use App\Shop\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use App\Shop\Couriers\Repositories\CourierRepository;
use App\Shop\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use App\Shop\Customers\Repositories\CustomerRepository;
use App\Shop\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Shop\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Shop\Orders\Repositories\OrderRepository;
use App\Shop\OrderStatuses\Repositories\Interfaces\OrderStatusRepositoryInterface;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;
use App\Shop\Permissions\Repositories\PermissionRepository;
use App\Shop\Permissions\Repositories\Interfaces\PermissionRepositoryInterface;
use App\Shop\ProductAttributes\Repositories\ProductAttributeRepository;
use App\Shop\ProductAttributes\Repositories\ProductAttributeRepositoryInterface;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Repositories\ProductRepository;
use App\Shop\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;
use App\Shop\Provinces\Repositories\ProvinceRepository;
use App\Shop\Roles\Repositories\RoleRepository;
use App\Shop\Roles\Repositories\RoleRepositoryInterface;
use App\Shop\Shipping\ShippingInterface;
use App\Shop\Shipping\Shippo\ShippoShipmentRepository;
use App\Shop\States\Repositories\StateRepository;
use App\Shop\States\Repositories\StateRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            StateRepositoryInterface::class,
            StateRepository::class
        );

        $this->app->bind(
            ShippingInterface::class,
            ShippoShipmentRepository::class
        );

        $this->app->bind(
            BrandRepositoryInterface::class,
            BrandRepository::class
        );

        $this->app->bind(
            ProductAttributeRepositoryInterface::class,
            ProductAttributeRepository::class
        );

        $this->app->bind(
            AttributeValueRepositoryInterface::class,
            AttributeValueRepository::class
        );

        $this->app->bind(
            AttributeRepositoryInterface::class,
            AttributeRepository::class
        );

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
            CartRepositoryInterface::class,
            CartRepository::class
        );

        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );

        $this->app->bind(
            PermissionRepositoryInterface::class,
            PermissionRepository::class
        );
    }
}

<?php

namespace Laracommerce\Core\Providers;

use Laracommerce\Core\Addresses\Repositories\AddressRepository;
use Laracommerce\Core\Addresses\Repositories\Interfaces\AddressRepositoryInterface;
use Laracommerce\Core\Attributes\Repositories\AttributeRepository;
use Laracommerce\Core\Attributes\Repositories\AttributeRepositoryInterface;
use Laracommerce\Core\AttributeValues\Repositories\AttributeValueRepository;
use Laracommerce\Core\AttributeValues\Repositories\AttributeValueRepositoryInterface;
use Laracommerce\Core\Carts\Repositories\CartRepository;
use Laracommerce\Core\Carts\Repositories\Interfaces\CartRepositoryInterface;
use Laracommerce\Core\Categories\Repositories\CategoryRepository;
use Laracommerce\Core\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use Laracommerce\Core\Cities\Repositories\CityRepository;
use Laracommerce\Core\Cities\Repositories\Interfaces\CityRepositoryInterface;
use Laracommerce\Core\Countries\Repositories\CountryRepository;
use Laracommerce\Core\Countries\Repositories\Interfaces\CountryRepositoryInterface;
use Laracommerce\Core\Couriers\Repositories\CourierRepository;
use Laracommerce\Core\Couriers\Repositories\Interfaces\CourierRepositoryInterface;
use Laracommerce\Core\Customers\Repositories\CustomerRepository;
use Laracommerce\Core\Customers\Repositories\Interfaces\CustomerRepositoryInterface;
use Laracommerce\Core\Employees\Repositories\EmployeeRepository;
use Laracommerce\Core\Employees\Repositories\Interfaces\EmployeeRepositoryInterface;
use Laracommerce\Core\OrderDetails\Repositories\Interfaces\OrderProductRepositoryInterface;
use Laracommerce\Core\OrderDetails\Repositories\OrderProductRepository;
use Laracommerce\Core\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use Laracommerce\Core\Orders\Repositories\OrderRepository;
use Laracommerce\Core\OrderStatuses\Repositories\Interfaces\OrderStatusRepositoryInterface;
use Laracommerce\Core\OrderStatuses\Repositories\OrderStatusRepository;
use Laracommerce\Core\PaymentMethods\Repositories\Interfaces\PaymentMethodRepositoryInterface;
use Laracommerce\Core\PaymentMethods\Repositories\PaymentMethodRepository;
use Laracommerce\Core\ProductAttributes\Repositories\ProductAttributeRepository;
use Laracommerce\Core\ProductAttributes\Repositories\ProductAttributeRepositoryInterface;
use Laracommerce\Core\Products\Repositories\Interfaces\ProductRepositoryInterface;
use Laracommerce\Core\Products\Repositories\ProductRepository;
use Laracommerce\Core\Provinces\Repositories\Interfaces\ProvinceRepositoryInterface;
use Laracommerce\Core\Provinces\Repositories\ProvinceRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            OrderProductRepositoryInterface::class,
            OrderProductRepository::class
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
            PaymentMethodRepositoryInterface::class,
            PaymentMethodRepository::class
        );

        $this->app->bind(
            CartRepositoryInterface::class,
            CartRepository::class
        );
    }
}

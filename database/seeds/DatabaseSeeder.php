<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(EmployeesTableSeeder::class);
        $this->call(CustomersTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(CategoryProductsTableSeeder::class);
        $this->call(MyCountryTableSeeder::class);
        $this->call(ProvincesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(CustomerAddressesTableSeeder::class);
        $this->call(PaymentMethodTableSeeder::class);
        $this->call(CourierTableSeeder::class);
        $this->call(OrderStatusTableSeeder::class);
        $this->call(OrderTableSeeder::class);
    }
}

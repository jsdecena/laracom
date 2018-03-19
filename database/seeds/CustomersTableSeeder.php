<?php

use Laracommerce\Core\Customers\Customer;
use Illuminate\Database\Seeder;

class CustomersTableSeeder extends Seeder
{
    public function run()
    {
        factory(Customer::class)->create();
    }
}
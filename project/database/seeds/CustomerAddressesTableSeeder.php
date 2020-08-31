<?php

use App\Shop\Addresses\Address;
use App\Shop\Customers\Customer;
use Illuminate\Database\Seeder;

class CustomerAddressesTableSeeder extends Seeder
{
    public function run()
    {
        factory(Customer::class, 3)->create()->each(function ($customer) {
            factory(Address::class, 3)->make()->each(function($address) use ($customer) {
                $customer->addresses()->save($address);
            });
        });
    }
}
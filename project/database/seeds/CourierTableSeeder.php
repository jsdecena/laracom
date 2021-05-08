<?php

use App\Shop\Couriers\Courier;
use Illuminate\Database\Seeder;

class CourierTableSeeder extends Seeder
{
    public function run()
    {
        factory(Courier::class)->create([
            'name' => 'Free Shipping',
            'description' => 'Free Shipping'
        ]);
    }
}
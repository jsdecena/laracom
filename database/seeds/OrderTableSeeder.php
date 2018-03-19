<?php

use Laracommerce\Core\Orders\Order;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    public function run()
    {
        factory(Order::class, 10)->create();
    }
}
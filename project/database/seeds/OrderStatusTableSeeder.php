<?php

use App\Shop\OrderStatuses\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    public function run()
    {
        factory(OrderStatus::class)->create([
            'name' => 'paid',
            'color' => 'green'
        ]);

        factory(OrderStatus::class)->create([
            'name' => 'pending',
            'color' => 'yellow'
        ]);

        factory(OrderStatus::class)->create([
            'name' => 'error',
            'color' => 'red'
        ]);

        factory(OrderStatus::class)->create([
            'name' => 'on-delivery',
            'color' => 'blue'
        ]);

        factory(OrderStatus::class)->create([
            'name' => 'ordered',
            'color' => 'violet'
        ]);
    }
}
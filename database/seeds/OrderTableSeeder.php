<?php

use App\Shop\Orders\Order;
use App\Shop\Products\Product;
use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    public function run()
    {
        factory(Order::class, 10)->create()->each(function (Order $order) {
            factory(Product::class, 3)->make()->each(function($product) use ($order) {
                $order->products()->save($product, [
                    'quantity' => 1,
                    'product_name' => $product->name,
                    'product_price' => $product->price,
                    'product_sku' => $product->sku,
                    'product_description' => $product->description
                ]);
            });
        });
    }
}
<?php

use App\PaymentMethods\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodTableSeeder extends Seeder
{
    public function run()
    {
        factory(PaymentMethod::class)->create();
    }
}
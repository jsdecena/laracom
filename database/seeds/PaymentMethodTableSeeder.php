<?php

use App\Shop\PaymentMethods\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodTableSeeder extends Seeder
{
    public function run()
    {
        factory(PaymentMethod::class)->create([
            'name' => 'PayPal',
            'slug' => 'paypal',
            'description' => '',
            'account_id' => config('paypal.account_id'),
            'client_id' => config('paypal.client_id'),
            'client_secret' => config('paypal.client_secret'),
            'api_url' => config('paypal.api_url'),
            'redirect_url' => env('APP_URL'),
            'cancel_url' => env('APP_URL'),
            'failed_url' => env('APP_URL'),
            'mode' => config('paypal.mode')
        ]);
    }
}
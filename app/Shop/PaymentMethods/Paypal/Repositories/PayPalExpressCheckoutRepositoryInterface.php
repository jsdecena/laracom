<?php

namespace App\Shop\PaymentMethods\Paypal\Repositories;

use App\Shop\Couriers\Courier;
use Illuminate\Http\Request;

interface PayPalExpressCheckoutRepositoryInterface
{
    public function getApiContext();

    public function process(Courier $courier, Request $request);

    public function execute(Request $request);
}

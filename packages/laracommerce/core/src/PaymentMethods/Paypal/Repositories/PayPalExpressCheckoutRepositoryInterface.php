<?php

namespace Laracommerce\Core\PaymentMethods\Paypal\Repositories;

use Laracommerce\Core\Couriers\Courier;
use Illuminate\Http\Request;

interface PayPalExpressCheckoutRepositoryInterface
{
    public function getApiContext();

    public function process(Courier $courier, Request $request);

    public function execute(Request $request);
}

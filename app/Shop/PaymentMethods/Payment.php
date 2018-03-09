<?php

namespace App\Shop\PaymentMethods;

class Payment
{
    protected $payment;

    /**
     * Payment constructor.
     * @param $class
     */
    public function __construct($class)
    {
        $this->payment = $class;
    }

    public function init()
    {
        return $this->payment;
    }
}

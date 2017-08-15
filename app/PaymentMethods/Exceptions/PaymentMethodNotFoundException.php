<?php

namespace App\PaymentMethods\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaymentMethodNotFoundException extends NotFoundHttpException
{
    /**
     * PaymentMethodNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Payment method not found.');
    }
}
<?php

namespace App\Orders\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderNotFoundException extends NotFoundHttpException
{
    public function __construct()
    {
        parent::__construct('Order not found.');
    }
}
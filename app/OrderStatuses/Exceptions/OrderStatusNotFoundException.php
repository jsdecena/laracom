<?php

namespace App\OrderStatuses\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class OrderStatusNotFoundException extends NotFoundHttpException
{
    /**
     * OrderStatusNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Order status not found.');
    }
}
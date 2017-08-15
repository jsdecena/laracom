<?php

namespace App\Carts\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductInCartNotFoundException extends NotFoundHttpException
{

    /**
     * ProductInCartNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Product in cart not found.');
    }
}
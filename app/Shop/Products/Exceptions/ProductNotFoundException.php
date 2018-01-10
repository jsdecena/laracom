<?php

namespace App\Shop\Products\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductNotFoundException extends NotFoundHttpException
{

    /**
     * ProductNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Product not found.');
    }
}
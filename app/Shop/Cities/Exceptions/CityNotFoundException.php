<?php

namespace App\Shop\Cities\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CityNotFoundException extends NotFoundHttpException
{
    /**
     * CityNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('City not found.');
    }
}

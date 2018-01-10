<?php

namespace App\Shop\Countries\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CountryNotFoundException extends NotFoundHttpException
{
    /**
     * CountryNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Country not found.');
    }
}
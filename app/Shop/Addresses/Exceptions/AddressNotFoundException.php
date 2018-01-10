<?php

namespace App\Shop\Addresses\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AddressNotFoundException extends NotFoundHttpException
{

    /**
     * AddressNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Address not found.');
    }
}
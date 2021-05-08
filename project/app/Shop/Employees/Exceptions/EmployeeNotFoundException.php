<?php

namespace App\Shop\Employees\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EmployeeNotFoundException extends NotFoundHttpException
{

    /**
     * EmployeeNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Employee not found.');
    }
}

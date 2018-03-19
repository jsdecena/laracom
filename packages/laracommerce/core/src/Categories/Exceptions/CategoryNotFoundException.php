<?php

namespace Laracommerce\Core\Categories\Exceptions;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CategoryNotFoundException extends NotFoundHttpException
{
    /**
     * CategoryNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct('Category not found.');
    }
}

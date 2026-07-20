<?php

namespace App\Exceptions;

use RuntimeException;

class CategoryNotFoundException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('Category not found.');
    }
}

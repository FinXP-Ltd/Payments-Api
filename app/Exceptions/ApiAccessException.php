<?php

namespace App\Exceptions;

use Exception;

class ApiAccessException extends Exception
{
    public static function notSet(): self
    {
        return new static('API Keys are not set!');
    }
}

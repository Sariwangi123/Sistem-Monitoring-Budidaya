<?php

namespace Finance\Exceptions;

use Exception;

class InvalidCostObjectException extends Exception
{
    protected $message = 'The specified cost object is invalid or not found.';
}
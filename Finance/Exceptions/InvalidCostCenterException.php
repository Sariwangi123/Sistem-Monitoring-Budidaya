<?php

namespace Finance\Exceptions;

use Exception;

class InvalidCostCenterException extends Exception
{
    protected $message = 'The specified cost center is invalid or not found.';
}
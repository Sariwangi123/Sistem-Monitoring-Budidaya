<?php

namespace Finance\Exceptions;

use Exception;

class InvalidFinancialPeriodException extends Exception
{
    protected $message = 'The specified financial period is invalid.';
}
<?php

namespace Finance\Exceptions;

use Exception;

class ProfitCalculationException extends Exception
{
    protected $message = 'An error occurred during the profit calculation process.';
}
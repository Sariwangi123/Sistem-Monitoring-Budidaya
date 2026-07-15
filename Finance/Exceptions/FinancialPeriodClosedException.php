<?php

namespace Finance\Exceptions;

use Exception;

class FinancialPeriodClosedException extends Exception
{
    protected $message = 'The financial period is closed and cannot accept transactions.';
}
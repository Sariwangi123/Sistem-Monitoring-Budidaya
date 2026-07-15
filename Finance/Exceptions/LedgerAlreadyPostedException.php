<?php

namespace Finance\Exceptions;

use Exception;

class LedgerAlreadyPostedException extends Exception
{
    protected $message = 'The financial ledger entry has already been posted and cannot be modified.';
}
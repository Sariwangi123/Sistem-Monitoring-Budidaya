<?php

namespace Finance\Http\Controllers;

use Finance\Http\Requests\FinanceExpenseRequest;
use Finance\Http\Resources\FinanceExpenseResource;
use Finance\Services\FinanceExpenseService;
use MasterData\Http\Controllers\BaseController;

final class FinanceExpenseController extends BaseController
{
    public function __construct(FinanceExpenseService $service)
    {
        parent::__construct($service, FinanceExpenseResource::class, FinanceExpenseRequest::class);
    }
}

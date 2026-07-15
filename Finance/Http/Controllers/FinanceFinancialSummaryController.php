<?php

namespace Finance\Http\Controllers;

use Finance\Http\Requests\FinanceFinancialSummaryRequest;
use Finance\Http\Resources\FinanceFinancialSummaryResource;
use Finance\Services\FinanceFinancialSummaryService;
use MasterData\Http\Controllers\BaseController;

final class FinanceFinancialSummaryController extends BaseController
{
    public function __construct(FinanceFinancialSummaryService $service)
    {
        parent::__construct($service, FinanceFinancialSummaryResource::class, FinanceFinancialSummaryRequest::class);
    }
}

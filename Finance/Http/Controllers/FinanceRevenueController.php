<?php

namespace Finance\Http\Controllers;

use Finance\Http\Requests\FinanceRevenueRequest;
use Finance\Http\Resources\FinanceRevenueResource;
use Finance\Services\FinanceRevenueService;
use MasterData\Http\Controllers\BaseController;

final class FinanceRevenueController extends BaseController
{
    public function __construct(FinanceRevenueService $service)
    {
        parent::__construct($service, FinanceRevenueResource::class, FinanceRevenueRequest::class);
    }
}

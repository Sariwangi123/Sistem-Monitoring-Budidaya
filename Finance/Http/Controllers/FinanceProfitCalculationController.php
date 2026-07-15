<?php

namespace Finance\Http\Controllers;

use Finance\Http\Requests\FinanceProfitCalculationRequest;
use Finance\Http\Resources\FinanceProfitCalculationResource;
use Finance\Services\FinanceProfitCalculationService;
use MasterData\Http\Controllers\BaseController;

final class FinanceProfitCalculationController extends BaseController
{
    public function __construct(FinanceProfitCalculationService $service)
    {
        parent::__construct($service, FinanceProfitCalculationResource::class, FinanceProfitCalculationRequest::class);
    }
}

<?php

namespace Finance\Repositories;

use Finance\Models\FinanceProfitCalculation;
use Finance\Repositories\Contracts\FinanceProfitCalculationRepositoryInterface;
use MasterData\Repositories\BaseRepository;

final class FinanceProfitCalculationRepository extends BaseRepository implements FinanceProfitCalculationRepositoryInterface
{
    public function __construct(FinanceProfitCalculation $model)
    {
        parent::__construct($model);
    }
}

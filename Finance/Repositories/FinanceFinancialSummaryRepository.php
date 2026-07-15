<?php

namespace Finance\Repositories;

use Finance\Models\FinanceFinancialSummary;
use Finance\Repositories\Contracts\FinanceFinancialSummaryRepositoryInterface;
use MasterData\Repositories\BaseRepository;

final class FinanceFinancialSummaryRepository extends BaseRepository implements FinanceFinancialSummaryRepositoryInterface
{
    public function __construct(FinanceFinancialSummary $model)
    {
        parent::__construct($model);
    }
}

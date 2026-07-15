<?php

namespace Finance\Repositories;

use Finance\Models\FinanceExpense;
use Finance\Repositories\Contracts\FinanceExpenseRepositoryInterface;
use MasterData\Repositories\BaseRepository;

final class FinanceExpenseRepository extends BaseRepository implements FinanceExpenseRepositoryInterface
{
    public function __construct(FinanceExpense $model)
    {
        parent::__construct($model);
    }
}

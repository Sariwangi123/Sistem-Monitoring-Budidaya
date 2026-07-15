<?php

namespace Finance\Repositories;

use Finance\Models\FinanceRevenue;
use Finance\Repositories\Contracts\FinanceRevenueRepositoryInterface;
use MasterData\Repositories\BaseRepository;

final class FinanceRevenueRepository extends BaseRepository implements FinanceRevenueRepositoryInterface
{
    public function __construct(FinanceRevenue $model)
    {
        parent::__construct($model);
    }
}

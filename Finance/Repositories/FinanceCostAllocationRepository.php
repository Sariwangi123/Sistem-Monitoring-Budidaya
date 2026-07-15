<?php

namespace Finance\Repositories;

use Finance\Models\FinanceCostAllocation;
use Finance\Repositories\Contracts\FinanceCostAllocationRepositoryInterface;
use MasterData\Repositories\BaseRepository;

final class FinanceCostAllocationRepository extends BaseRepository implements FinanceCostAllocationRepositoryInterface
{
    public function __construct(FinanceCostAllocation $model)
    {
        parent::__construct($model);
    }
}

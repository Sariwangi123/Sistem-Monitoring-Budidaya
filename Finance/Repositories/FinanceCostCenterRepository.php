<?php

namespace Finance\Repositories;

use Finance\Models\FinanceCostCenter;
use Finance\Repositories\Contracts\FinanceCostCenterRepositoryInterface;
use MasterData\Repositories\BaseRepository;

final class FinanceCostCenterRepository extends BaseRepository implements FinanceCostCenterRepositoryInterface
{
    public function __construct(FinanceCostCenter $model)
    {
        parent::__construct($model);
    }
}

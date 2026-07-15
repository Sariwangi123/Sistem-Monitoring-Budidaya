<?php

namespace Finance\Services;

use Finance\Repositories\Contracts\FinanceCostCenterRepositoryInterface;
use Illuminate\Support\Facades\DB;
use MasterData\Services\BaseService;

final class FinanceCostCenterService extends BaseService
{
    public function __construct(FinanceCostCenterRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data): object
    {
        return DB::transaction(fn (): object => parent::create($data));
    }

    public function update(int|string $id, array $data): object
    {
        return DB::transaction(fn (): object => parent::update($id, $data));
    }

    public function getActiveCostCenters(): \Illuminate\Support\Collection
    {
        return $this->repository->getAll(['*'])
            ->where('status', 'Active');
    }
}
<?php

namespace Finance\Services;

use Finance\Exceptions\InvalidCostCenterException;
use Finance\Models\FinanceCostCenter;
use Finance\Repositories\Contracts\FinanceCostAllocationRepositoryInterface;
use Illuminate\Support\Facades\DB;
use MasterData\Services\BaseService;

final class FinanceCostAllocationService extends BaseService
{
    public function __construct(FinanceCostAllocationRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data): object
    {
        $this->validateAllocation($data);

        if (empty($data['allocation_number'])) {
            $data['allocation_number'] = 'ALLOC-' . strtoupper(uniqid());
        }

        return DB::transaction(fn (): object => parent::create($data));
    }

    public function update(int|string $id, array $data): object
    {
        $allocation = $this->findById($id);
        if (!$allocation) {
            throw new \InvalidArgumentException('Cost allocation not found.');
        }

        $mergedData = array_merge($allocation->toArray(), $data);
        $this->validateAllocation($mergedData);

        return DB::transaction(fn (): object => parent::update($id, $data));
    }

    private function validateAllocation(array $data): void
    {
        $percentage = $data['allocation_percentage'] ?? null;
        if ($percentage !== null && ($percentage < 0 || $percentage > 100)) {
            throw new \InvalidArgumentException('Allocation percentage must be between 0 and 100.');
        }

        $sourceId = $data['source_cost_center_id'] ?? null;
        if ($sourceId) {
            $source = FinanceCostCenter::find($sourceId);
            if (!$source || $source->status !== 'Active') {
                throw new InvalidCostCenterException('Source cost center is invalid or inactive.');
            }
        }

        $targetId = $data['target_cost_center_id'] ?? null;
        if ($targetId) {
            $target = FinanceCostCenter::find($targetId);
            if (!$target || $target->status !== 'Active') {
                throw new InvalidCostCenterException('Target cost center is invalid or inactive.');
            }
        }
    }
}
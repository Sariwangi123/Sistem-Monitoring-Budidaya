<?php

namespace Harvest\Services;

use Illuminate\Support\Facades\DB;
use Harvest\Repositories\HarvestBatchRepository;

final class HarvestBatchService extends \MasterData\Services\BaseService
{
    public function __construct(HarvestBatchRepository $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data): object
    {
        return DB::transaction(fn (): object => parent::create($data));
    }

    public function update(int|string $id, array $data): object
    {
        $batch = $this->findById($id);

        $this->ensureEditable($batch);

        return DB::transaction(fn (): object => parent::update($id, $data));
    }

    public function startBatch(int|string $id): object
    {
        return $this->transition($id, ['Ready', 'Scheduled'], 'Harvesting');
    }

    public function moveToQualityControl(int|string $id): object
    {
        return $this->transition($id, ['Harvesting'], 'QC');
    }

    public function moveToPacking(int|string $id): object
    {
        return $this->transition($id, ['QC'], 'Packing');
    }

    public function markDelivered(int|string $id): object
    {
        return $this->transition($id, ['Packing'], 'Delivered');
    }

    public function completeBatch(int|string $id): object
    {
        return $this->transition($id, ['Delivered'], 'Completed');
    }

    private function transition(int|string $id, array $allowedStatuses, string $nextStatus): object
    {
        $batch = $this->findById($id);

        if (! $batch) {
            throw new \InvalidArgumentException('Harvest batch not found.');
        }

        if (! in_array((string) $batch->status, $allowedStatuses, true)) {
            throw new \InvalidArgumentException("Harvest batch status '{$batch->status}' cannot transition to '{$nextStatus}'.");
        }

        return DB::transaction(fn (): object => parent::update($id, ['status' => $nextStatus]));
    }

    private function ensureEditable(?object $batch): void
    {
        if (! $batch) {
            throw new \InvalidArgumentException('Harvest batch not found.');
        }

        if ((string) $batch->status === 'Completed') {
            throw new \InvalidArgumentException('Completed harvest batch cannot be changed.');
        }
    }
}

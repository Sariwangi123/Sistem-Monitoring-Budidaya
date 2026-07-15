<?php

namespace Harvest\Services;

use Illuminate\Support\Facades\DB;
use Harvest\Repositories\HarvestRepository;

final class HarvestService extends \MasterData\Services\BaseService
{
    public function __construct(HarvestRepository $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data): object
    {
        return DB::transaction(fn (): object => parent::create($data));
    }

    public function update(int|string $id, array $data): object
    {
        $harvest = $this->findById($id);

        $this->ensureEditable($harvest);

        return DB::transaction(fn (): object => parent::update($id, $data));
    }

    public function markReady(int|string $id): object
    {
        return $this->transition($id, ['Planning', 'Scheduled'], 'Ready');
    }

    public function startHarvest(int|string $id): object
    {
        return $this->transition($id, ['Ready'], 'Harvesting', [
            'started_at' => now(),
        ]);
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

    public function completeHarvest(int|string $id): object
    {
        return $this->transition($id, ['Delivered'], 'Completed', [
            'completed_at' => now(),
        ]);
    }

    public function closeHarvest(int|string $id): object
    {
        return $this->transition($id, ['Completed'], 'Closed');
    }

    private function transition(int|string $id, array $allowedStatuses, string $nextStatus, array $payload = []): object
    {
        $harvest = $this->findById($id);

        if (! $harvest) {
            throw new \InvalidArgumentException('Harvest not found.');
        }

        if (! in_array((string) $harvest->status, $allowedStatuses, true)) {
            throw new \InvalidArgumentException("Harvest status '{$harvest->status}' cannot transition to '{$nextStatus}'.");
        }

        return DB::transaction(fn (): object => parent::update($id, [
            ...$payload,
            'status' => $nextStatus,
        ]));
    }

    private function ensureEditable(?object $harvest): void
    {
        if (! $harvest) {
            throw new \InvalidArgumentException('Harvest not found.');
        }

        if (in_array((string) $harvest->status, ['Completed', 'Closed'], true)) {
            throw new \InvalidArgumentException('Completed harvest cannot be changed.');
        }
    }
}

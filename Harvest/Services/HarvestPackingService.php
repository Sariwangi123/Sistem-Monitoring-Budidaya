<?php

namespace Harvest\Services;

use Illuminate\Support\Facades\DB;
use Harvest\Repositories\HarvestPackingRepository;

final class HarvestPackingService extends \MasterData\Services\BaseService
{
    public function __construct(HarvestPackingRepository $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data): object
    {
        return DB::transaction(fn (): object => parent::create($data));
    }

    public function update(int|string $id, array $data): object
    {
        $packing = $this->findById($id);

        $this->ensureEditable($packing);

        return DB::transaction(fn (): object => parent::update($id, $data));
    }

    public function completePacking(int|string $id): object
    {
        return $this->transition($id, ['Draft', 'Packing', 'Packed'], 'Packed');
    }

    public function markDelivered(int|string $id): object
    {
        return $this->transition($id, ['Packed'], 'Delivered');
    }

    private function transition(int|string $id, array $allowedStatuses, string $nextStatus): object
    {
        $packing = $this->findById($id);

        if (! $packing) {
            throw new \InvalidArgumentException('Harvest packing not found.');
        }

        if (! in_array((string) $packing->status, $allowedStatuses, true)) {
            throw new \InvalidArgumentException("Harvest packing status '{$packing->status}' cannot transition to '{$nextStatus}'.");
        }

        return DB::transaction(fn (): object => parent::update($id, ['status' => $nextStatus]));
    }

    private function ensureEditable(?object $packing): void
    {
        if (! $packing) {
            throw new \InvalidArgumentException('Harvest packing not found.');
        }

        if ((string) $packing->status === 'Delivered') {
            throw new \InvalidArgumentException('Delivered packing cannot be changed.');
        }
    }
}

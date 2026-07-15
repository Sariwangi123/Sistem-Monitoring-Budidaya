<?php

namespace Harvest\Services;

use Illuminate\Support\Facades\DB;
use Harvest\Repositories\HarvestDeliveryRepository;

final class HarvestDeliveryService extends \MasterData\Services\BaseService
{
    public function __construct(HarvestDeliveryRepository $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data): object
    {
        return DB::transaction(fn (): object => parent::create($data));
    }

    public function update(int|string $id, array $data): object
    {
        $delivery = $this->findById($id);

        $this->ensureEditable($delivery);

        return DB::transaction(fn (): object => parent::update($id, $data));
    }

    public function startDelivery(int|string $id): object
    {
        return $this->transition($id, ['Scheduled'], 'In Transit');
    }

    public function completeDelivery(int|string $id): object
    {
        return $this->transition($id, ['Scheduled', 'In Transit'], 'Delivered');
    }

    private function transition(int|string $id, array $allowedStatuses, string $nextStatus): object
    {
        $delivery = $this->findById($id);

        if (! $delivery) {
            throw new \InvalidArgumentException('Harvest delivery not found.');
        }

        if (! in_array((string) $delivery->delivery_status, $allowedStatuses, true)) {
            throw new \InvalidArgumentException("Harvest delivery status '{$delivery->delivery_status}' cannot transition to '{$nextStatus}'.");
        }

        return DB::transaction(fn (): object => parent::update($id, ['delivery_status' => $nextStatus]));
    }

    private function ensureEditable(?object $delivery): void
    {
        if (! $delivery) {
            throw new \InvalidArgumentException('Harvest delivery not found.');
        }

        if ((string) $delivery->delivery_status === 'Delivered') {
            throw new \InvalidArgumentException('Delivered harvest cannot be changed.');
        }
    }
}

<?php

namespace Database\Factories\Warehouse;

use Database\Factories\Warehouse\Concerns\ResolvesWarehouseDependencies;
use Illuminate\Database\Eloquent\Factories\Factory;
use Warehouse\Models\InventoryBatch;

final class InventoryBatchFactory extends Factory
{
    use ResolvesWarehouseDependencies;

    protected $model = InventoryBatch::class;

    public function definition(): array
    {
        $receivedDate = fake()->dateTimeBetween('-2 months', 'now');

        return [
            'inventory_item_id' => $this->inventoryItemId(),
            'warehouse_location_id' => $this->warehouseLocationId(),
            'batch_number' => strtoupper(fake()->unique()->bothify('BATCH-####')),
            'lot_number' => strtoupper(fake()->unique()->bothify('LOT-####')),
            'production_date' => (clone $receivedDate)->modify('-1 month')->format('Y-m-d'),
            'expired_date' => (clone $receivedDate)->modify('+10 months')->format('Y-m-d'),
            'received_date' => $receivedDate->format('Y-m-d'),
            'status' => 'Available',
        ];
    }
}

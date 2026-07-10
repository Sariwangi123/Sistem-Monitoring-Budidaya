<?php

namespace Database\Factories\Warehouse;

use Database\Factories\Warehouse\Concerns\ResolvesWarehouseDependencies;
use Illuminate\Database\Eloquent\Factories\Factory;
use Warehouse\Models\InventoryBatch;
use Warehouse\Models\InventoryStock;

final class InventoryStockFactory extends Factory
{
    use ResolvesWarehouseDependencies;

    protected $model = InventoryStock::class;

    public function definition(): array
    {
        $batchId = $this->inventoryBatchId();
        $batch = InventoryBatch::query()->find($batchId);
        $currentQuantity = fake()->randomFloat(2, 50, 1000);
        $reservedQuantity = fake()->randomFloat(2, 0, 50);

        return [
            'inventory_item_id' => $batch?->inventory_item_id ?? $this->inventoryItemId(),
            'warehouse_location_id' => $batch?->warehouse_location_id ?? $this->warehouseLocationId(),
            'batch_id' => $batchId,
            'current_quantity' => $currentQuantity,
            'reserved_quantity' => $reservedQuantity,
            'available_quantity' => max(0, $currentQuantity - $reservedQuantity),
            'last_movement_at' => now(),
        ];
    }
}

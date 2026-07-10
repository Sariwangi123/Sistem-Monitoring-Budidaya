<?php

namespace Database\Factories\Warehouse;

use Database\Factories\Warehouse\Concerns\ResolvesWarehouseDependencies;
use Illuminate\Database\Eloquent\Factories\Factory;
use Warehouse\Models\InventoryBatch;
use Warehouse\Models\WarehouseLocation;
use Warehouse\Models\InventoryMovement;

final class InventoryMovementFactory extends Factory
{
    use ResolvesWarehouseDependencies;

    protected $model = InventoryMovement::class;

    public function definition(): array
    {
        $batchId = $this->inventoryBatchId();
        $batch = InventoryBatch::query()->find($batchId);
        $location = WarehouseLocation::query()->find($batch?->warehouse_location_id ?? $this->warehouseLocationId());
        $quantity = fake()->randomFloat(2, 10, 250);
        $unitCost = fake()->randomFloat(2, 5000, 25000);

        return [
            'inventory_item_id' => $batch?->inventory_item_id ?? $this->inventoryItemId(),
            'warehouse_id' => $location?->warehouse_id ?? $this->warehouseId(),
            'warehouse_location_id' => $location?->id ?? $this->warehouseLocationId(),
            'batch_id' => $batchId,
            'culture_cycle_id' => null,
            'activity_id' => null,
            'user_id' => $this->userId(),
            'movement_number' => strtoupper(fake()->unique()->bothify('MOV-######')),
            'movement_type' => fake()->randomElement(['Stock In', 'Stock Out', 'Adjustment Plus', 'Adjustment Minus']),
            'movement_date' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'quantity' => $quantity,
            'unit_cost' => $unitCost,
            'total_cost' => $quantity * $unitCost,
            'reference_type' => fake()->optional()->randomElement(['Receiving', 'Feeding', 'Adjustment']),
            'reference_uuid' => fake()->optional()->uuid(),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}

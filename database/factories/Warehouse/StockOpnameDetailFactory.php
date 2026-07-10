<?php

namespace Database\Factories\Warehouse;

use Database\Factories\Warehouse\Concerns\ResolvesWarehouseDependencies;
use Illuminate\Database\Eloquent\Factories\Factory;
use Warehouse\Models\InventoryBatch;
use Warehouse\Models\StockOpnameDetail;

final class StockOpnameDetailFactory extends Factory
{
    use ResolvesWarehouseDependencies;

    protected $model = StockOpnameDetail::class;

    public function definition(): array
    {
        $batchId = $this->inventoryBatchId();
        $batch = InventoryBatch::query()->find($batchId);
        $systemQuantity = fake()->randomFloat(2, 100, 500);
        $physicalQuantity = fake()->randomFloat(2, 80, 520);

        return [
            'stock_opname_id' => $this->stockOpnameId(),
            'inventory_item_id' => $batch?->inventory_item_id ?? $this->inventoryItemId(),
            'batch_id' => $batchId,
            'system_quantity' => $systemQuantity,
            'physical_quantity' => $physicalQuantity,
            'difference_quantity' => $physicalQuantity - $systemQuantity,
            'adjustment_required' => abs($physicalQuantity - $systemQuantity) > 0,
            'notes' => fake()->optional()->sentence(),
        ];
    }
}

<?php

namespace Database\Factories\Warehouse;

use Database\Factories\Warehouse\Concerns\ResolvesWarehouseDependencies;
use Illuminate\Database\Eloquent\Factories\Factory;
use Warehouse\Models\InventoryItem;

final class InventoryItemFactory extends Factory
{
    use ResolvesWarehouseDependencies;

    protected $model = InventoryItem::class;

    public function definition(): array
    {
        return [
            'item_category_id' => $this->itemCategoryId(),
            'unit_id' => $this->unitId(),
            'supplier_id' => $this->supplierId(),
            'item_code' => strtoupper(fake()->unique()->lexify('ITM???')),
            'item_name' => fake()->words(2, true),
            'brand' => fake()->company(),
            'specification' => fake()->optional()->sentence(),
            'minimum_stock' => fake()->randomFloat(2, 10, 100),
            'maximum_stock' => fake()->randomFloat(2, 500, 2000),
            'reorder_level' => fake()->randomFloat(2, 50, 200),
            'status' => 'Active',
        ];
    }
}

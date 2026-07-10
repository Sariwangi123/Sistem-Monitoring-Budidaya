<?php

namespace Database\Factories\Warehouse;

use Database\Factories\Warehouse\Concerns\ResolvesWarehouseDependencies;
use Illuminate\Database\Eloquent\Factories\Factory;
use Warehouse\Models\WarehouseLocation;

final class WarehouseLocationFactory extends Factory
{
    use ResolvesWarehouseDependencies;

    protected $model = WarehouseLocation::class;

    public function definition(): array
    {
        return [
            'warehouse_id' => $this->warehouseId(),
            'location_code' => strtoupper(fake()->unique()->lexify('LOC???')),
            'location_name' => fake()->word().' Rack',
            'description' => fake()->optional()->sentence(),
            'status' => 'Active',
        ];
    }
}

<?php

namespace Database\Factories\Warehouse;

use Database\Factories\Warehouse\Concerns\ResolvesWarehouseDependencies;
use Illuminate\Database\Eloquent\Factories\Factory;
use Warehouse\Models\Warehouse;

final class WarehouseFactory extends Factory
{
    use ResolvesWarehouseDependencies;

    protected $model = Warehouse::class;

    public function definition(): array
    {
        return [
            'farm_id' => $this->farmId(),
            'warehouse_code' => strtoupper(fake()->unique()->lexify('WHS???')),
            'warehouse_name' => fake()->company().' Warehouse',
            'description' => fake()->optional()->sentence(),
            'status' => fake()->randomElement(['Active', 'Inactive']),
        ];
    }
}

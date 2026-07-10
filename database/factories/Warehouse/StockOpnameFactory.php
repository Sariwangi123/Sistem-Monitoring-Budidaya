<?php

namespace Database\Factories\Warehouse;

use Database\Factories\Warehouse\Concerns\ResolvesWarehouseDependencies;
use Illuminate\Database\Eloquent\Factories\Factory;
use Warehouse\Models\StockOpname;

final class StockOpnameFactory extends Factory
{
    use ResolvesWarehouseDependencies;

    protected $model = StockOpname::class;

    public function definition(): array
    {
        return [
            'warehouse_id' => $this->warehouseId(),
            'user_id' => $this->userId(),
            'opname_number' => strtoupper(fake()->unique()->bothify('OPN-######')),
            'opname_date' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'status' => fake()->randomElement(['Draft', 'Submitted', 'Approved', 'Completed']),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}

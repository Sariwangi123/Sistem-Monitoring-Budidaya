<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\Pond;

final class PondFactory extends Factory
{
    protected $model = Pond::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'pond_area_id' => \MasterData\Models\PondArea::factory(),
            'pond_code' => strtoupper(fake()->unique()->lexify('PND???')),
            'pond_name' => fake()->word(),
            'pond_type' => fake()->randomElement(['EARTHEN', 'CONCRETE', 'TARP', 'FIBERGLASS']),
            'pond_shape' => fake()->randomElement(['RECTANGLE', 'SQUARE', 'CIRCLE', 'IRREGULAR']),
            'length' => fake()->randomFloat(2, 10, 100),
            'width' => fake()->randomFloat(2, 10, 100),
            'depth' => fake()->randomFloat(2, 1, 5),
            'volume' => fake()->randomFloat(2, 100, 5000),
            'water_capacity' => fake()->randomFloat(2, 100, 5000),
            'status' => fake()->randomElement(['ACTIVE', 'INACTIVE', 'MAINTENANCE']),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
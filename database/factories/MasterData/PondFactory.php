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
            'area_size' => fake()->randomFloat(2, 100, 5000),
            'depth' => fake()->randomFloat(2, 1, 5),
            'volume' => fake()->randomFloat(2, 100, 5000),
            'description' => fake()->optional()->sentence(),
        ];
    }
}

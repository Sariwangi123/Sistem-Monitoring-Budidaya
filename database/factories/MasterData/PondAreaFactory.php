<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\PondArea;

final class PondAreaFactory extends Factory
{
    protected $model = PondArea::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'farm_id' => \MasterData\Models\Farm::factory(),
            'pond_area_code' => strtoupper(fake()->unique()->lexify('AREA???')),
            'pond_area_name' => fake()->word(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}

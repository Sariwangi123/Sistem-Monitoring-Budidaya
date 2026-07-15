<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\Unit;

final class UnitFactory extends Factory
{
    protected $model = Unit::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'unit_code' => strtoupper(fake()->unique()->lexify('???')),
            'unit_name' => fake()->word(),
            'symbol' => fake()->unique()->randomElement(['kg', 'g', 'L', 'ml', 'm', 'cm', 'pcs', 'box', 'sack', 'ton']),
        ];
    }
}

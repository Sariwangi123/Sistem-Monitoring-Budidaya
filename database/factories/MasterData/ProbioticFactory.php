<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\Probiotic;

final class ProbioticFactory extends Factory
{
    protected $model = Probiotic::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'probiotic_code' => strtoupper(fake()->unique()->lexify('PRO???')),
            'probiotic_name' => fake()->unique()->word(),
            'bacterial_strain' => fake()->word(),
            'manufacturer' => fake()->company(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}

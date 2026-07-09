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
            'dosage' => fake()->randomElement(['250ml', '500ml', '1L', '100g', '500g']),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
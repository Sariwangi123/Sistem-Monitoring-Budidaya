<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\Medicine;

final class MedicineFactory extends Factory
{
    protected $model = Medicine::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'medicine_code' => strtoupper(fake()->unique()->lexify('MED???')),
            'medicine_name' => fake()->unique()->word(),
            'dosage' => fake()->randomElement(['250ml', '500ml', '1L', '100g', '500g', '1kg']),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
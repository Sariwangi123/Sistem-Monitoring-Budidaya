<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\GeneralReference;

final class GeneralReferenceFactory extends Factory
{
    protected $model = GeneralReference::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'reference_code' => strtoupper(fake()->unique()->lexify('REF???')),
            'reference_name' => fake()->word(),
            'reference_group' => fake()->word(),
            'reference_value' => fake()->sentence(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}

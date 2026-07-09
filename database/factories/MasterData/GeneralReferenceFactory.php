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
            'ref_group' => fake()->word(),
            'ref_name' => fake()->word(),
            'ref_slug' => fake()->unique()->slug(),
            'ref_value' => fake()->sentence(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
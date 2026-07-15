<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\Vitamin;

final class VitaminFactory extends Factory
{
    protected $model = Vitamin::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'vitamin_code' => strtoupper(fake()->unique()->lexify('VIT???')),
            'vitamin_name' => fake()->unique()->word(),
            'composition' => fake()->word(),
            'manufacturer' => fake()->company(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}

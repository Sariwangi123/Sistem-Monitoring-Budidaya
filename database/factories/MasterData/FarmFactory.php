<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\Farm;

final class FarmFactory extends Factory
{
    protected $model = Farm::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'company_id' => \MasterData\Models\Company::factory(),
            'farm_code' => strtoupper(fake()->unique()->lexify('FRM???')),
            'farm_name' => fake()->unique()->city(),
            'latitude' => fake()->latitude(),
            'longitude' => fake()->longitude(),
            'area_size' => fake()->randomFloat(2, 100, 10000),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\Province;

final class ProvinceFactory extends Factory
{
    protected $model = Province::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'province_code' => strtoupper(fake()->unique()->lexify('PROV???')),
            'province_name' => fake()->state(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
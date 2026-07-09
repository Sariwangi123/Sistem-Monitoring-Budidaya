<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\Village;

final class VillageFactory extends Factory
{
    protected $model = Village::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'district_id' => \MasterData\Models\District::factory(),
            'village_code' => strtoupper(fake()->unique()->lexify('VIL???')),
            'village_name' => fake()->citySuffix(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
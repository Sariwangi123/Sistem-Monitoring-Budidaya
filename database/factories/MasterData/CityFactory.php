<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\City;

final class CityFactory extends Factory
{
    protected $model = City::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'province_id' => \MasterData\Models\Province::factory(),
            'city_code' => strtoupper(fake()->unique()->lexify('CITY???')),
            'city_name' => fake()->city(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
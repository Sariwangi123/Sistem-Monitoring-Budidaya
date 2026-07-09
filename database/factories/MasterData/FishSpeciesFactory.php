<?php

namespace Database\Factories\MasterData;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use MasterData\Models\FishSpecies;

final class FishSpeciesFactory extends Factory
{
    protected $model = FishSpecies::class;

    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'species_code' => strtoupper(fake()->unique()->lexify('SP???')),
            'scientific_name' => fake()->unique()->word(),
            'local_name' => fake()->word(),
            'description' => fake()->optional()->sentence(),
        ];
    }
}
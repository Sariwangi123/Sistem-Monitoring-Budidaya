<?php

namespace Database\Factories\CultureCycle;

use CultureCycle\Models\CultureCycle;
use Illuminate\Database\Eloquent\Factories\Factory;

class CultureCycleFactory extends Factory
{
    protected $model = CultureCycle::class;

    public function definition(): array
    {
        $stockingDate = $this->faker->dateTimeBetween('-6 months', '-3 months');

        return [
            'company_id' => \MasterData\Models\Company::inRandomOrder()->first()?->id ?? 1,
            'farm_id' => \MasterData\Models\Farm::inRandomOrder()->first()?->id ?? 1,
            'pond_area_id' => \MasterData\Models\PondArea::inRandomOrder()->first()?->id ?? 1,
            'pond_id' => \MasterData\Models\Pond::inRandomOrder()->first()?->id ?? 1,
            'fish_species_id' => \MasterData\Models\FishSpecies::inRandomOrder()->first()?->id ?? 1,
            'fish_strain_id' => \MasterData\Models\FishStrain::inRandomOrder()->first()?->id ?? 1,
            'supplier_id' => \MasterData\Models\Supplier::inRandomOrder()->first()?->id ?? 1,
            'employee_id' => \MasterData\Models\Employee::inRandomOrder()->first()?->id ?? 1,
            'cycle_code' => 'CC-' . strtoupper(\Illuminate\Support\Str::random(6)),
            'cycle_name' => 'Siklus ' . $this->faker->date('M Y'),
            'stocking_date' => $stockingDate,
            'estimated_harvest_date' => (clone $stockingDate)->modify('+3 months'),
            'actual_harvest_date' => null,
            'initial_seed_quantity' => $this->faker->numberBetween(5000, 50000),
            'current_population' => $this->faker->numberBetween(4000, 45000),
            'initial_average_weight' => $this->faker->randomFloat(4, 0.1, 0.5),
            'current_average_weight' => $this->faker->randomFloat(4, 100, 500),
            'current_biomass' => $this->faker->randomFloat(4, 500, 5000),
            'status' => $this->faker->randomElement(['active', 'completed', 'cancelled']),
            'notes' => $this->faker->optional()->sentence,
        ];
    }
}
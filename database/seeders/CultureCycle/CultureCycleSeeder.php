<?php

namespace Database\Seeders\CultureCycle;

use Carbon\Carbon;
use CultureCycle\Models\CultureCycle;
use CultureCycle\Models\CultureCycleFeedSummary;
use CultureCycle\Models\CultureCycleMortality;
use CultureCycle\Models\CultureCycleSampling;
use CultureCycle\Models\CultureCycleWaterQuality;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CultureCycleSeeder extends Seeder
{
    public function run(): void
    {
        $cycle = CultureCycle::query()->create([
            'uuid' => (string) Str::uuid(),
            'company_id' => 1,
            'farm_id' => 1,
            'pond_id' => 1,
            'fish_species_id' => 1,
            'fish_strain_id' => 1,
            'cycle_number' => 1,
            'stocking_date' => Carbon::now()->subDays(60),
            'estimated_harvest_date' => Carbon::now()->addDays(30),
            'initial_stock' => 10000,
            'current_stock' => 8500,
            'average_body_weight' => 150.00,
            'status' => 'active',
            'notes' => 'Siklus perdana pembesaran ikan Nila',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        // Sampling
        CultureCycleSampling::query()->create([
            'uuid' => (string) Str::uuid(),
            'culture_cycle_id' => $cycle->id,
            'sampling_date' => Carbon::now()->subDays(30),
            'sample_count' => 100,
            'average_weight' => 75.00,
            'average_length' => 12.50,
            'condition_factor' => 1.02,
            'notes' => 'Sampling pertama',
            'created_by' => 1,
        ]);

        CultureCycleSampling::query()->create([
            'uuid' => (string) Str::uuid(),
            'culture_cycle_id' => $cycle->id,
            'sampling_date' => Carbon::now()->subDays(15),
            'sample_count' => 100,
            'average_weight' => 120.00,
            'average_length' => 15.20,
            'condition_factor' => 1.05,
            'notes' => 'Sampling kedua',
            'created_by' => 1,
        ]);

        // Mortality
        CultureCycleMortality::query()->create([
            'uuid' => (string) Str::uuid(),
            'culture_cycle_id' => $cycle->id,
            'incident_date' => Carbon::now()->subDays(45),
            'total_dead' => 500,
            'mortality_rate' => 5.00,
            'cause' => 'penyakit',
            'notes' => 'Serangan bakteri pada minggu kedua',
            'created_by' => 1,
        ]);

        CultureCycleMortality::query()->create([
            'uuid' => (string) Str::uuid(),
            'culture_cycle_id' => $cycle->id,
            'incident_date' => Carbon::now()->subDays(20),
            'total_dead' => 1000,
            'mortality_rate' => 10.53,
            'cause' => 'predator',
            'notes' => 'Serangan burung',
            'created_by' => 1,
        ]);

        // Water Quality
        CultureCycleWaterQuality::query()->create([
            'uuid' => (string) Str::uuid(),
            'culture_cycle_id' => $cycle->id,
            'measurement_date' => Carbon::now()->subDays(30),
            'temperature' => 28.5,
            'ph' => 7.2,
            'dissolved_oxygen' => 5.5,
            'salinity' => 0.5,
            'ammonia' => 0.25,
            'nitrite' => 0.10,
            'nitrate' => 5.00,
            'turbidity' => 15.00,
            'water_level' => 120.00,
            'notes' => 'Kualitas air dalam kondisi baik',
            'created_by' => 1,
        ]);

        CultureCycleWaterQuality::query()->create([
            'uuid' => (string) Str::uuid(),
            'culture_cycle_id' => $cycle->id,
            'measurement_date' => Carbon::now()->subDays(15),
            'temperature' => 29.0,
            'ph' => 7.5,
            'dissolved_oxygen' => 5.0,
            'salinity' => 0.6,
            'ammonia' => 0.30,
            'nitrite' => 0.15,
            'nitrate' => 6.00,
            'turbidity' => 20.00,
            'water_level' => 115.00,
            'notes' => 'Kualitas air stabil',
            'created_by' => 1,
        ]);

        // Feed Summary
        CultureCycleFeedSummary::query()->create([
            'uuid' => (string) Str::uuid(),
            'culture_cycle_id' => $cycle->id,
            'feed_type_id' => 1,
            'feed_brand_id' => 1,
            'total_feed_used' => 500.00,
            'total_feed_cost' => 5000000.00,
            'fcr' => 1.2,
            'period_start' => Carbon::now()->subDays(60),
            'period_end' => Carbon::now()->subDays(30),
            'notes' => 'Pakan periode awal',
            'created_by' => 1,
        ]);

        CultureCycleFeedSummary::query()->create([
            'uuid' => (string) Str::uuid(),
            'culture_cycle_id' => $cycle->id,
            'feed_type_id' => 2,
            'feed_brand_id' => 1,
            'total_feed_used' => 800.00,
            'total_feed_cost' => 8800000.00,
            'fcr' => 1.3,
            'period_start' => Carbon::now()->subDays(30),
            'period_end' => Carbon::now(),
            'notes' => 'Pakan periode pertumbuhan',
            'created_by' => 1,
        ]);
    }
}
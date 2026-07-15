<?php

namespace Database\Seeders\Harvest;

use Activities\Models\Activity;
use Activities\Models\ActivityCategory;
use Activities\Models\ActivityType;
use CultureCycle\Models\CultureCycle;
use Harvest\Models\Harvest;
use Harvest\Models\HarvestBatch;
use Harvest\Models\HarvestDelivery;
use Harvest\Models\HarvestGrade;
use Harvest\Models\HarvestPacking;
use Harvest\Models\HarvestQualityControl;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use MasterData\Models\Company;
use MasterData\Models\Customer;
use MasterData\Models\Employee;
use MasterData\Models\Farm;
use MasterData\Models\FishSpecies;
use MasterData\Models\FishStrain;
use MasterData\Models\Pond;
use MasterData\Models\PondArea;
use MasterData\Models\Supplier;
use Modules\Users\Models\User;

final class HarvestSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::query()->firstOrCreate(
            ['company_code' => 'CMP-HRV'],
            ['company_name' => 'Harvest Company']
        );

        $farm = Farm::query()->firstOrCreate(
            ['farm_code' => 'FRM-HRV'],
            ['company_id' => $company->id, 'farm_name' => 'Harvest Farm']
        );

        $pondArea = PondArea::query()->firstOrCreate(
            ['pond_area_code' => 'AREA-HRV'],
            ['farm_id' => $farm->id, 'pond_area_name' => 'Harvest Pond Area']
        );

        $pond = Pond::query()->firstOrCreate(
            ['pond_code' => 'PND-HRV'],
            ['pond_area_id' => $pondArea->id, 'pond_name' => 'Harvest Pond']
        );

        $fishSpecies = FishSpecies::query()->firstOrCreate(
            ['fish_species_code' => 'FSP-HRV'],
            ['fish_species_name' => 'Tilapia', 'scientific_name' => 'Oreochromis niloticus']
        );

        $fishStrain = FishStrain::query()->firstOrCreate(
            ['fish_strain_code' => 'FSR-HRV'],
            ['fish_species_id' => $fishSpecies->id, 'fish_strain_name' => 'Nirwana']
        );

        $supplier = Supplier::query()->firstOrCreate(
            ['supplier_code' => 'SUP-HRV'],
            ['supplier_name' => 'Harvest Seed Supplier', 'supplier_type' => 'seed']
        );

        $employee = Employee::query()->firstOrCreate(
            ['employee_code' => 'EMP-HRV'],
            ['employee_name' => 'Harvest Technician', 'position' => 'Technician', 'department' => 'Production', 'is_active' => true]
        );

        $customer = Customer::query()->firstOrCreate(
            ['customer_code' => 'CUST-HRV'],
            ['customer_name' => 'Harvest Customer', 'customer_type' => 'corporate', 'contact_person' => 'Purchasing']
        );

        $user = User::query()->firstOrCreate(
            ['email' => 'harvest.user@example.com'],
            ['name' => 'Harvest User', 'password' => Hash::make('password'), 'is_active' => true]
        );

        $cultureCycle = CultureCycle::query()->firstOrCreate(
            ['cycle_code' => 'CYC-HRV'],
            [
                'uuid' => (string) Str::uuid(),
                'company_id' => $company->id,
                'farm_id' => $farm->id,
                'pond_area_id' => $pondArea->id,
                'pond_id' => $pond->id,
                'fish_species_id' => $fishSpecies->id,
                'fish_strain_id' => $fishStrain->id,
                'supplier_id' => $supplier->id,
                'employee_id' => $employee->id,
                'cycle_name' => 'Harvest Culture Cycle',
                'stocking_date' => now()->subMonths(4)->toDateString(),
                'estimated_harvest_date' => now()->addWeek()->toDateString(),
                'initial_seed_quantity' => 10000,
                'current_population' => 9200,
                'initial_average_weight' => 10,
                'current_average_weight' => 250,
                'current_biomass' => 2300,
                'status' => 'Active',
            ]
        );

        $activityCategory = ActivityCategory::query()->firstOrCreate(
            ['category_code' => 'ACT-HRV'],
            ['category_name' => 'Harvest', 'status' => 'Active']
        );

        $activityType = ActivityType::query()->firstOrCreate(
            ['event_code' => 'ACT-HRV-PLAN'],
            [
                'activity_category_id' => $activityCategory->id,
                'activity_name' => 'Harvest Planning',
                'is_manual' => false,
                'is_system' => true,
                'status' => 'Active',
            ]
        );

        $activity = Activity::query()->firstOrCreate(
            ['event_code' => 'EVT-HRV-PLAN'],
            [
                'company_id' => $company->id,
                'farm_id' => $farm->id,
                'pond_area_id' => $pondArea->id,
                'pond_id' => $pond->id,
                'culture_cycle_id' => $cultureCycle->id,
                'activity_type_id' => $activityType->id,
                'user_id' => $user->id,
                'activity_date' => now()->toDateString(),
                'activity_time' => now()->format('H:i:s'),
                'title' => 'Harvest planning activity',
                'status' => 'Completed',
                'reference_type' => 'Harvest',
            ]
        );

        $harvest = Harvest::query()->firstOrCreate(
            ['harvest_code' => 'HRV-001'],
            [
                'company_id' => $company->id,
                'farm_id' => $farm->id,
                'pond_area_id' => $pondArea->id,
                'pond_id' => $pond->id,
                'culture_cycle_id' => $cultureCycle->id,
                'customer_id' => $customer->id,
                'responsible_user_id' => $user->id,
                'activity_id' => $activity->id,
                'harvest_name' => 'Partial Harvest Cycle HRV',
                'harvest_type' => 'Partial Harvest',
                'planned_harvest_date' => now()->addDay()->toDateString(),
                'harvest_date' => now()->toDateString(),
                'started_at' => now()->subHours(5),
                'completed_at' => now()->subHour(),
                'estimated_population' => 2000,
                'estimated_biomass' => 500,
                'total_harvest_population' => 1900,
                'total_harvest_weight' => 475,
                'average_weight' => 0.25,
                'survival_rate' => 95,
                'feed_conversion_ratio' => 1.35,
                'average_daily_gain' => 2.1,
                'status' => 'Completed',
                'notes' => 'Seeded partial harvest sample.',
            ]
        );

        $batch = HarvestBatch::query()->firstOrCreate(
            ['batch_code' => 'HB-001'],
            [
                'harvest_id' => $harvest->id,
                'culture_cycle_id' => $cultureCycle->id,
                'batch_name' => 'Harvest Batch 001',
                'harvest_date' => now()->toDateString(),
                'harvest_population' => 1900,
                'gross_weight' => 500,
                'net_weight' => 475,
                'average_weight' => 0.25,
                'status' => 'Completed',
                'notes' => 'Seeded harvest batch sample.',
            ]
        );

        HarvestQualityControl::query()->firstOrCreate(
            ['harvest_batch_id' => $batch->id, 'qc_date' => now()->toDateString()],
            [
                'harvest_id' => $harvest->id,
                'qc_user_id' => $user->id,
                'average_weight' => 0.25,
                'fish_size' => 'Medium',
                'fish_condition' => 'Fresh',
                'damage_rate' => 1.5,
                'qc_status' => 'Passed',
                'qc_notes' => 'Seeded QC passed.',
            ]
        );

        $grade = HarvestGrade::query()->firstOrCreate(
            ['harvest_batch_id' => $batch->id, 'grade_code' => 'A'],
            [
                'harvest_id' => $harvest->id,
                'grade_name' => 'Grade A',
                'fish_count' => 1200,
                'total_weight' => 330,
                'average_weight' => 0.275,
                'quality_status' => 'Accepted',
            ]
        );

        $packing = HarvestPacking::query()->firstOrCreate(
            ['packing_code' => 'HP-001'],
            [
                'harvest_id' => $harvest->id,
                'harvest_batch_id' => $batch->id,
                'harvest_grade_id' => $grade->id,
                'operator_user_id' => $user->id,
                'packing_date' => now()->toDateString(),
                'package_type' => 'Box',
                'package_quantity' => 33,
                'net_weight' => 330,
                'gross_weight' => 350,
                'status' => 'Packed',
            ]
        );

        HarvestDelivery::query()->firstOrCreate(
            ['delivery_code' => 'HD-001'],
            [
                'harvest_id' => $harvest->id,
                'harvest_packing_id' => $packing->id,
                'customer_id' => $customer->id,
                'driver_user_id' => $user->id,
                'document_number' => 'SJ-HRV-001',
                'delivery_date' => now()->toDateString(),
                'vehicle_number' => 'B 1234 HRV',
                'driver_name' => 'Harvest Driver',
                'package_quantity' => 33,
                'delivered_weight' => 330,
                'delivery_status' => 'Delivered',
                'notes' => 'Seeded harvest delivery sample.',
            ]
        );
    }
}

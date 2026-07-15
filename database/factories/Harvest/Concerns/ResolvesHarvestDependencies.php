<?php

namespace Database\Factories\Harvest\Concerns;

use Activities\Models\Activity;
use Activities\Models\ActivityCategory;
use Activities\Models\ActivityType;
use CultureCycle\Models\CultureCycle;
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
use Harvest\Models\Harvest;
use Harvest\Models\HarvestBatch;
use Harvest\Models\HarvestGrade;
use Harvest\Models\HarvestPacking;

trait ResolvesHarvestDependencies
{
    protected function companyId(): int
    {
        return Company::query()->firstOrCreate(
            ['company_code' => 'CMP-HRV'],
            ['company_name' => 'Harvest Company']
        )->id;
    }

    protected function farmId(): int
    {
        return Farm::query()->firstOrCreate(
            ['farm_code' => 'FRM-HRV'],
            ['company_id' => $this->companyId(), 'farm_name' => 'Harvest Farm']
        )->id;
    }

    protected function pondAreaId(): int
    {
        return PondArea::query()->firstOrCreate(
            ['pond_area_code' => 'AREA-HRV'],
            ['farm_id' => $this->farmId(), 'pond_area_name' => 'Harvest Pond Area']
        )->id;
    }

    protected function pondId(): int
    {
        return Pond::query()->firstOrCreate(
            ['pond_code' => 'PND-HRV'],
            [
                'pond_area_id' => $this->pondAreaId(),
                'pond_name' => 'Harvest Pond',
                'area_size' => 1000,
                'depth' => 1.5,
                'volume' => 1500,
            ]
        )->id;
    }

    protected function fishSpeciesId(): int
    {
        return FishSpecies::query()->firstOrCreate(
            ['fish_species_code' => 'FSP-HRV'],
            ['fish_species_name' => 'Tilapia', 'scientific_name' => 'Oreochromis niloticus']
        )->id;
    }

    protected function fishStrainId(): int
    {
        return FishStrain::query()->firstOrCreate(
            ['fish_strain_code' => 'FSR-HRV'],
            ['fish_species_id' => $this->fishSpeciesId(), 'fish_strain_name' => 'Nirwana']
        )->id;
    }

    protected function supplierId(): int
    {
        return Supplier::query()->firstOrCreate(
            ['supplier_code' => 'SUP-HRV'],
            ['supplier_name' => 'Harvest Seed Supplier', 'supplier_type' => 'seed']
        )->id;
    }

    protected function employeeId(): int
    {
        return Employee::query()->firstOrCreate(
            ['employee_code' => 'EMP-HRV'],
            [
                'employee_name' => 'Harvest Technician',
                'position' => 'Technician',
                'department' => 'Production',
                'is_active' => true,
            ]
        )->id;
    }

    protected function customerId(): int
    {
        return Customer::query()->firstOrCreate(
            ['customer_code' => 'CUST-HRV'],
            [
                'customer_name' => 'Harvest Customer',
                'customer_type' => 'corporate',
                'contact_person' => 'Purchasing',
            ]
        )->id;
    }

    protected function userId(): int
    {
        return User::query()->firstOrCreate(
            ['email' => 'harvest.user@example.com'],
            ['name' => 'Harvest User', 'password' => Hash::make('password'), 'is_active' => true]
        )->id;
    }

    protected function cultureCycleId(): int
    {
        return CultureCycle::query()->firstOrCreate(
            ['cycle_code' => 'CYC-HRV'],
            [
                'uuid' => (string) Str::uuid(),
                'company_id' => $this->companyId(),
                'farm_id' => $this->farmId(),
                'pond_area_id' => $this->pondAreaId(),
                'pond_id' => $this->pondId(),
                'fish_species_id' => $this->fishSpeciesId(),
                'fish_strain_id' => $this->fishStrainId(),
                'supplier_id' => $this->supplierId(),
                'employee_id' => $this->employeeId(),
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
        )->id;
    }

    protected function activityId(): int
    {
        $category = ActivityCategory::query()->firstOrCreate(
            ['category_code' => 'ACT-HRV'],
            ['category_name' => 'Harvest', 'status' => 'Active']
        );

        $type = ActivityType::query()->firstOrCreate(
            ['event_code' => 'ACT-HRV-PLAN'],
            [
                'activity_category_id' => $category->id,
                'activity_name' => 'Harvest Planning',
                'is_manual' => false,
                'is_system' => true,
                'status' => 'Active',
            ]
        );

        return Activity::query()->firstOrCreate(
            ['event_code' => 'EVT-HRV-PLAN'],
            [
                'company_id' => $this->companyId(),
                'farm_id' => $this->farmId(),
                'pond_area_id' => $this->pondAreaId(),
                'pond_id' => $this->pondId(),
                'culture_cycle_id' => $this->cultureCycleId(),
                'activity_type_id' => $type->id,
                'user_id' => $this->userId(),
                'activity_date' => now()->toDateString(),
                'activity_time' => now()->format('H:i:s'),
                'title' => 'Harvest planning activity',
                'status' => 'Completed',
                'reference_type' => 'Harvest',
            ]
        )->id;
    }

    protected function harvestId(): int
    {
        return Harvest::query()->firstOrCreate(
            ['harvest_code' => 'HRV-MAIN'],
            [
                'company_id' => $this->companyId(),
                'farm_id' => $this->farmId(),
                'pond_area_id' => $this->pondAreaId(),
                'pond_id' => $this->pondId(),
                'culture_cycle_id' => $this->cultureCycleId(),
                'customer_id' => $this->customerId(),
                'responsible_user_id' => $this->userId(),
                'activity_id' => $this->activityId(),
                'harvest_name' => 'Main Harvest',
                'harvest_type' => 'Partial Harvest',
                'planned_harvest_date' => now()->addDay()->toDateString(),
                'harvest_date' => now()->toDateString(),
                'estimated_population' => 2000,
                'estimated_biomass' => 500,
                'total_harvest_population' => 1900,
                'total_harvest_weight' => 475,
                'average_weight' => 0.25,
                'status' => 'Completed',
            ]
        )->id;
    }

    protected function harvestBatchId(): int
    {
        return HarvestBatch::query()->firstOrCreate(
            ['batch_code' => 'HB-MAIN'],
            [
                'harvest_id' => $this->harvestId(),
                'culture_cycle_id' => $this->cultureCycleId(),
                'batch_name' => 'Main Harvest Batch',
                'harvest_date' => now()->toDateString(),
                'harvest_population' => 1900,
                'gross_weight' => 500,
                'net_weight' => 475,
                'average_weight' => 0.25,
                'status' => 'Completed',
            ]
        )->id;
    }

    protected function harvestGradeId(): int
    {
        return HarvestGrade::query()->firstOrCreate(
            ['harvest_batch_id' => $this->harvestBatchId(), 'grade_code' => 'A'],
            [
                'harvest_id' => $this->harvestId(),
                'grade_name' => 'Grade A',
                'fish_count' => 1200,
                'total_weight' => 330,
                'average_weight' => 0.275,
                'quality_status' => 'Accepted',
            ]
        )->id;
    }

    protected function harvestPackingId(): int
    {
        return HarvestPacking::query()->firstOrCreate(
            ['packing_code' => 'HP-MAIN'],
            [
                'harvest_id' => $this->harvestId(),
                'harvest_batch_id' => $this->harvestBatchId(),
                'harvest_grade_id' => $this->harvestGradeId(),
                'operator_user_id' => $this->userId(),
                'packing_date' => now()->toDateString(),
                'package_type' => 'Box',
                'package_quantity' => 33,
                'net_weight' => 330,
                'gross_weight' => 350,
                'status' => 'Packed',
            ]
        )->id;
    }
}

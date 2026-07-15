<?php

namespace Tests\Unit\Harvest;

use CultureCycle\Models\CultureCycle;
use Harvest\Models\Harvest;
use Harvest\Models\HarvestBatch;
use Harvest\Models\HarvestDelivery;
use Harvest\Services\HarvestBatchService;
use Harvest\Services\HarvestDeliveryService;
use Harvest\Services\HarvestService;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
use Tests\TestCase;

final class HarvestServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_harvest_service_moves_through_status_workflow(): void
    {
        $context = $this->createHarvestContext();
        $harvest = $this->createHarvest($context, ['status' => 'Planning']);
        $service = $this->app->make(HarvestService::class);

        $service->markReady($harvest->id);
        $this->assertDatabaseHas('harvests', ['id' => $harvest->id, 'status' => 'Ready']);

        $service->startHarvest($harvest->id);
        $this->assertDatabaseHas('harvests', ['id' => $harvest->id, 'status' => 'Harvesting']);

        $service->moveToQualityControl($harvest->id);
        $this->assertDatabaseHas('harvests', ['id' => $harvest->id, 'status' => 'QC']);

        $service->moveToPacking($harvest->id);
        $this->assertDatabaseHas('harvests', ['id' => $harvest->id, 'status' => 'Packing']);

        $service->markDelivered($harvest->id);
        $this->assertDatabaseHas('harvests', ['id' => $harvest->id, 'status' => 'Delivered']);

        $service->completeHarvest($harvest->id);
        $this->assertDatabaseHas('harvests', ['id' => $harvest->id, 'status' => 'Completed']);
    }

    public function test_harvest_service_rejects_invalid_status_transition(): void
    {
        $context = $this->createHarvestContext();
        $harvest = $this->createHarvest($context, ['status' => 'Planning']);
        $service = $this->app->make(HarvestService::class);

        $this->expectException(\InvalidArgumentException::class);

        $service->completeHarvest($harvest->id);
    }

    public function test_harvest_batch_and_delivery_services_move_through_operational_statuses(): void
    {
        $context = $this->createHarvestContext();
        $harvest = $this->createHarvest($context, ['status' => 'Harvesting']);
        $batch = HarvestBatch::query()->create([
            'harvest_id' => $harvest->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'batch_code' => 'HB-SVC-001',
            'batch_name' => 'Service Harvest Batch',
            'harvest_date' => '2026-07-15',
            'status' => 'Harvesting',
        ]);
        $delivery = HarvestDelivery::query()->create([
            'harvest_id' => $harvest->id,
            'customer_id' => $context['customer']->id,
            'driver_user_id' => $context['user']->id,
            'delivery_code' => 'HD-SVC-001',
            'document_number' => 'DOC-HRV-SVC-001',
            'delivery_date' => '2026-07-16',
            'delivery_status' => 'Scheduled',
        ]);

        $batchService = $this->app->make(HarvestBatchService::class);
        $deliveryService = $this->app->make(HarvestDeliveryService::class);

        $batchService->moveToQualityControl($batch->id);
        $this->assertDatabaseHas('harvest_batches', ['id' => $batch->id, 'status' => 'QC']);

        $batchService->moveToPacking($batch->id);
        $this->assertDatabaseHas('harvest_batches', ['id' => $batch->id, 'status' => 'Packing']);

        $batchService->markDelivered($batch->id);
        $this->assertDatabaseHas('harvest_batches', ['id' => $batch->id, 'status' => 'Delivered']);

        $batchService->completeBatch($batch->id);
        $this->assertDatabaseHas('harvest_batches', ['id' => $batch->id, 'status' => 'Completed']);

        $deliveryService->startDelivery($delivery->id);
        $this->assertDatabaseHas('harvest_deliveries', ['id' => $delivery->id, 'delivery_status' => 'In Transit']);

        $deliveryService->completeDelivery($delivery->id);
        $this->assertDatabaseHas('harvest_deliveries', ['id' => $delivery->id, 'delivery_status' => 'Delivered']);
    }

    private function createHarvest(array $context, array $overrides = []): Harvest
    {
        return Harvest::query()->create([
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'pond_area_id' => $context['pond_area']->id,
            'pond_id' => $context['pond']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'customer_id' => $context['customer']->id,
            'responsible_user_id' => $context['user']->id,
            'harvest_code' => 'HRV-SVC-001',
            'harvest_name' => 'Service Harvest',
            'harvest_type' => 'Partial Harvest',
            'planned_harvest_date' => '2026-07-14',
            'harvest_date' => '2026-07-15',
            'estimated_population' => 10000,
            'estimated_biomass' => 1250,
            'status' => 'Planning',
            ...$overrides,
        ]);
    }

    private function createHarvestContext(): array
    {
        $user = User::query()->create([
            'name' => 'Harvest Service Tester',
            'email' => 'harvest.service.tester@example.com',
            'password' => 'password',
            'is_active' => true,
        ]);

        $company = Company::query()->create([
            'company_code' => 'CMP-HSV',
            'company_name' => 'Harvest Service Company',
        ]);

        $farm = Farm::query()->create([
            'company_id' => $company->id,
            'farm_code' => 'FRM-HSV',
            'farm_name' => 'Harvest Service Farm',
        ]);

        $pondArea = PondArea::query()->create([
            'farm_id' => $farm->id,
            'pond_area_code' => 'PA-HSV',
            'pond_area_name' => 'Harvest Service Pond Area',
        ]);

        $pond = Pond::query()->create([
            'pond_area_id' => $pondArea->id,
            'pond_code' => 'PND-HSV',
            'pond_name' => 'Harvest Service Pond',
        ]);

        $fishSpecies = FishSpecies::query()->create([
            'fish_species_code' => 'FSP-HSV',
            'fish_species_name' => 'Harvest Service Species',
        ]);

        $fishStrain = FishStrain::query()->create([
            'fish_species_id' => $fishSpecies->id,
            'fish_strain_code' => 'FST-HSV',
            'fish_strain_name' => 'Harvest Service Strain',
        ]);

        $supplier = Supplier::query()->create([
            'supplier_code' => 'SUP-HSV',
            'supplier_name' => 'Harvest Service Supplier',
            'supplier_type' => 'seed',
        ]);

        $employee = Employee::query()->create([
            'employee_code' => 'EMP-HSV',
            'employee_name' => 'Harvest Service Employee',
            'is_active' => true,
        ]);

        $customer = Customer::query()->create([
            'customer_code' => 'CUS-HSV',
            'customer_name' => 'Harvest Service Customer',
            'customer_type' => 'corporate',
        ]);

        $cultureCycle = CultureCycle::query()->create([
            'uuid' => Str::uuid()->toString(),
            'company_id' => $company->id,
            'farm_id' => $farm->id,
            'pond_area_id' => $pondArea->id,
            'pond_id' => $pond->id,
            'fish_species_id' => $fishSpecies->id,
            'fish_strain_id' => $fishStrain->id,
            'supplier_id' => $supplier->id,
            'employee_id' => $employee->id,
            'cycle_code' => 'CYC-HSV',
            'cycle_name' => 'Harvest Service Cycle',
            'status' => 'Active',
        ]);

        return [
            'user' => $user,
            'company' => $company,
            'farm' => $farm,
            'pond_area' => $pondArea,
            'pond' => $pond,
            'fish_species' => $fishSpecies,
            'fish_strain' => $fishStrain,
            'supplier' => $supplier,
            'employee' => $employee,
            'customer' => $customer,
            'culture_cycle' => $cultureCycle,
        ];
    }
}

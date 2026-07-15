<?php

namespace Tests\Feature\Harvest;

use CultureCycle\Models\CultureCycle;
use Harvest\Models\Harvest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
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

final class HarvestApiTest extends TestCase
{
    use RefreshDatabase;

    private const API_PREFIX = '/api/v1/harvest';

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::query()->create([
            'name' => 'Harvest Tester',
            'email' => 'harvest.tester@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
    }

    public function test_harvest_crud_restore_and_force_delete_flow(): void
    {
        $this->authenticate();

        $context = $this->createHarvestContext();

        $createResponse = $this->postJson(self::API_PREFIX, [
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'pond_area_id' => $context['pond_area']->id,
            'pond_id' => $context['pond']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'customer_id' => $context['customer']->id,
            'responsible_user_id' => $this->user->id,
            'harvest_code' => 'HRV-API-001',
            'harvest_name' => 'API Harvest',
            'harvest_type' => 'Partial Harvest',
            'planned_harvest_date' => '2026-07-14',
            'harvest_date' => '2026-07-15',
            'estimated_population' => 10000,
            'estimated_biomass' => 1250,
            'status' => 'Planning',
        ]);

        $createResponse->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.harvest_code', 'HRV-API-001');

        $uuid = $createResponse->json('data.uuid');

        $this->getJson(self::API_PREFIX."/{$uuid}")
            ->assertOk()
            ->assertJsonPath('data.harvest_name', 'API Harvest');

        $this->putJson(self::API_PREFIX."/{$uuid}", [
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'pond_area_id' => $context['pond_area']->id,
            'pond_id' => $context['pond']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'customer_id' => $context['customer']->id,
            'responsible_user_id' => $this->user->id,
            'harvest_code' => 'HRV-API-001-UPD',
            'harvest_name' => 'API Harvest Updated',
            'harvest_type' => 'Partial Harvest',
            'planned_harvest_date' => '2026-07-14',
            'harvest_date' => '2026-07-15',
            'estimated_population' => 10000,
            'estimated_biomass' => 1250,
            'status' => 'Scheduled',
        ])->assertOk()
            ->assertJsonPath('data.harvest_name', 'API Harvest Updated');

        $this->deleteJson(self::API_PREFIX."/{$uuid}")
            ->assertOk()
            ->assertJsonPath('message', 'Data deleted successfully');

        $this->assertSoftDeleted('harvests', ['uuid' => $uuid]);

        $this->postJson(self::API_PREFIX."/{$uuid}/restore")
            ->assertOk()
            ->assertJsonPath('message', 'Data restored successfully');

        $this->deleteJson(self::API_PREFIX."/{$uuid}")
            ->assertOk();

        $this->deleteJson(self::API_PREFIX."/{$uuid}/force")
            ->assertOk()
            ->assertJsonPath('message', 'Data permanently deleted');

        $this->assertDatabaseMissing('harvests', ['uuid' => $uuid]);
    }

    public function test_harvest_batch_qc_grade_packing_and_delivery_can_be_created(): void
    {
        $this->authenticate();

        $context = $this->createHarvestContext();
        $harvest = $this->createHarvest($context);

        $batchResponse = $this->postJson(self::API_PREFIX.'/batches', [
            'harvest_id' => $harvest->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'batch_code' => 'HB-API-001',
            'batch_name' => 'API Harvest Batch',
            'harvest_date' => '2026-07-15',
            'harvest_population' => 5000,
            'gross_weight' => 650,
            'net_weight' => 625,
            'average_weight' => 0.125,
            'status' => 'Harvesting',
        ]);

        $batchResponse->assertCreated()
            ->assertJsonPath('data.batch_code', 'HB-API-001');

        $batchId = $batchResponse->json('data.id');

        $this->postJson(self::API_PREFIX.'/quality-controls', [
            'harvest_id' => $harvest->id,
            'harvest_batch_id' => $batchId,
            'qc_user_id' => $this->user->id,
            'qc_date' => '2026-07-15',
            'average_weight' => 0.125,
            'fish_size' => 'Medium',
            'fish_condition' => 'Fresh',
            'damage_rate' => 0.5,
            'qc_status' => 'Passed',
        ])->assertCreated()
            ->assertJsonPath('data.qc_status', 'Passed');

        $gradeResponse = $this->postJson(self::API_PREFIX.'/grades', [
            'harvest_id' => $harvest->id,
            'harvest_batch_id' => $batchId,
            'grade_code' => 'A',
            'grade_name' => 'Grade A',
            'fish_count' => 3000,
            'total_weight' => 400,
            'average_weight' => 0.1333,
            'quality_status' => 'Accepted',
        ]);

        $gradeResponse->assertCreated()
            ->assertJsonPath('data.grade_code', 'A');

        $packingResponse = $this->postJson(self::API_PREFIX.'/packings', [
            'harvest_id' => $harvest->id,
            'harvest_batch_id' => $batchId,
            'harvest_grade_id' => $gradeResponse->json('data.id'),
            'operator_user_id' => $this->user->id,
            'packing_code' => 'HP-API-001',
            'packing_date' => '2026-07-15',
            'package_type' => 'Box',
            'package_quantity' => 40,
            'net_weight' => 400,
            'gross_weight' => 420,
            'status' => 'Packed',
        ]);

        $packingResponse->assertCreated()
            ->assertJsonPath('data.packing_code', 'HP-API-001');

        $this->postJson(self::API_PREFIX.'/deliveries', [
            'harvest_id' => $harvest->id,
            'harvest_packing_id' => $packingResponse->json('data.id'),
            'customer_id' => $context['customer']->id,
            'driver_user_id' => $this->user->id,
            'delivery_code' => 'HD-API-001',
            'document_number' => 'DOC-HRV-API-001',
            'delivery_date' => '2026-07-16',
            'vehicle_number' => 'B 1234 HRV',
            'driver_name' => 'Driver API',
            'package_quantity' => 40,
            'delivered_weight' => 400,
            'delivery_status' => 'Scheduled',
        ])->assertCreated()
            ->assertJsonPath('data.delivery_code', 'HD-API-001');
    }

    public function test_harvest_validation_rejects_missing_required_fields(): void
    {
        $this->authenticate();

        $this->postJson(self::API_PREFIX, [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'company_id',
                'farm_id',
                'pond_area_id',
                'pond_id',
                'culture_cycle_id',
                'responsible_user_id',
                'harvest_code',
                'harvest_name',
                'harvest_type',
                'harvest_date',
                'status',
            ]);
    }

    public function test_unauthenticated_user_cannot_access_harvest_api(): void
    {
        $this->getJson(self::API_PREFIX)
            ->assertUnauthorized();
    }

    private function authenticate(): void
    {
        Sanctum::actingAs($this->user);
    }

    private function createHarvest(array $context): Harvest
    {
        return Harvest::query()->create([
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'pond_area_id' => $context['pond_area']->id,
            'pond_id' => $context['pond']->id,
            'culture_cycle_id' => $context['culture_cycle']->id,
            'customer_id' => $context['customer']->id,
            'responsible_user_id' => $this->user->id,
            'harvest_code' => 'HRV-CTX-001',
            'harvest_name' => 'Context Harvest',
            'harvest_type' => 'Partial Harvest',
            'planned_harvest_date' => '2026-07-14',
            'harvest_date' => '2026-07-15',
            'estimated_population' => 10000,
            'estimated_biomass' => 1250,
            'status' => 'Harvesting',
        ]);
    }

    private function createHarvestContext(): array
    {
        $company = Company::query()->create([
            'company_code' => 'CMP-HRV',
            'company_name' => 'Harvest Test Company',
        ]);

        $farm = Farm::query()->create([
            'company_id' => $company->id,
            'farm_code' => 'FRM-HRV',
            'farm_name' => 'Harvest Test Farm',
        ]);

        $pondArea = PondArea::query()->create([
            'farm_id' => $farm->id,
            'pond_area_code' => 'PA-HRV',
            'pond_area_name' => 'Harvest Test Pond Area',
        ]);

        $pond = Pond::query()->create([
            'pond_area_id' => $pondArea->id,
            'pond_code' => 'PND-HRV',
            'pond_name' => 'Harvest Test Pond',
        ]);

        $fishSpecies = FishSpecies::query()->create([
            'fish_species_code' => 'FSP-HRV',
            'fish_species_name' => 'Harvest Test Species',
        ]);

        $fishStrain = FishStrain::query()->create([
            'fish_species_id' => $fishSpecies->id,
            'fish_strain_code' => 'FST-HRV',
            'fish_strain_name' => 'Harvest Test Strain',
        ]);

        $supplier = Supplier::query()->create([
            'supplier_code' => 'SUP-HRV',
            'supplier_name' => 'Harvest Test Supplier',
            'supplier_type' => 'seed',
        ]);

        $employee = Employee::query()->create([
            'employee_code' => 'EMP-HRV',
            'employee_name' => 'Harvest Test Employee',
            'is_active' => true,
        ]);

        $customer = Customer::query()->create([
            'customer_code' => 'CUS-HRV',
            'customer_name' => 'Harvest Test Customer',
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
            'cycle_code' => 'CYC-HRV',
            'cycle_name' => 'Harvest Test Cycle',
            'status' => 'Active',
        ]);

        return [
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

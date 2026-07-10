<?php

namespace Tests\Feature\Warehouse;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use MasterData\Models\Company;
use MasterData\Models\Farm;
use MasterData\Models\GeneralReference;
use MasterData\Models\Supplier;
use MasterData\Models\Unit;
use Modules\Users\Models\User;
use Tests\TestCase;
use Warehouse\Models\InventoryBatch;
use Warehouse\Models\InventoryItem;
use Warehouse\Models\InventoryStock;
use Warehouse\Models\Warehouse;
use Warehouse\Models\WarehouseLocation;

final class WarehouseApiTest extends TestCase
{
    use RefreshDatabase;

    private const API_PREFIX = '/api/v1/warehouse';

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::query()->create([
            'name' => 'Warehouse Tester',
            'email' => 'warehouse.tester@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);
    }

    public function test_warehouse_crud_flow(): void
    {
        $this->authenticate();

        $farm = $this->createFarm();

        $createResponse = $this->postJson(self::API_PREFIX.'/warehouses', [
            'farm_id' => $farm->id,
            'warehouse_code' => 'WHS-API-001',
            'warehouse_name' => 'API Warehouse',
            'description' => 'Warehouse created from API test.',
            'status' => 'Active',
        ]);

        $createResponse->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.warehouse_code', 'WHS-API-001');

        $uuid = $createResponse->json('data.uuid');

        $this->getJson(self::API_PREFIX."/warehouses/{$uuid}")
            ->assertOk()
            ->assertJsonPath('data.warehouse_name', 'API Warehouse');

        $this->putJson(self::API_PREFIX."/warehouses/{$uuid}", [
            'farm_id' => $farm->id,
            'warehouse_code' => 'WHS-API-001',
            'warehouse_name' => 'API Warehouse Updated',
            'status' => 'Active',
        ])->assertOk()
            ->assertJsonPath('data.warehouse_name', 'API Warehouse Updated');

        $this->deleteJson(self::API_PREFIX."/warehouses/{$uuid}")
            ->assertOk()
            ->assertJsonPath('message', 'Data deleted successfully');

        $this->assertSoftDeleted('warehouses', ['uuid' => $uuid]);
    }

    public function test_inventory_item_batch_stock_and_movement_can_be_created(): void
    {
        $this->authenticate();

        $context = $this->createInventoryContext();

        $itemResponse = $this->postJson(self::API_PREFIX.'/inventory-items', [
            'item_category_id' => $context['category']->id,
            'unit_id' => $context['unit']->id,
            'supplier_id' => $context['supplier']->id,
            'item_code' => 'ITEM-API-001',
            'item_name' => 'API Starter Feed',
            'brand' => 'UtiFeed',
            'minimum_stock' => 100,
            'maximum_stock' => 2000,
            'reorder_level' => 250,
            'status' => 'Active',
        ]);

        $itemResponse->assertCreated()
            ->assertJsonPath('data.item_code', 'ITEM-API-001');

        $itemId = $itemResponse->json('data.id');

        $batchResponse = $this->postJson(self::API_PREFIX.'/inventory-batches', [
            'inventory_item_id' => $itemId,
            'warehouse_location_id' => $context['location']->id,
            'batch_number' => 'BATCH-API-001',
            'lot_number' => 'LOT-API-001',
            'production_date' => '2026-06-01',
            'expired_date' => '2027-06-01',
            'received_date' => '2026-07-10',
            'status' => 'Available',
        ]);

        $batchResponse->assertCreated()
            ->assertJsonPath('data.batch_number', 'BATCH-API-001');

        $batchId = $batchResponse->json('data.id');

        $this->postJson(self::API_PREFIX.'/inventory-stocks', [
            'inventory_item_id' => $itemId,
            'warehouse_location_id' => $context['location']->id,
            'batch_id' => $batchId,
            'current_quantity' => 1000,
            'reserved_quantity' => 25,
            'available_quantity' => 975,
            'last_movement_at' => '2026-07-10 08:00:00',
        ])->assertCreated()
            ->assertJsonPath('data.available_quantity', '975.00');

        $this->postJson(self::API_PREFIX.'/inventory-movements', [
            'inventory_item_id' => $itemId,
            'warehouse_id' => $context['warehouse']->id,
            'warehouse_location_id' => $context['location']->id,
            'batch_id' => $batchId,
            'user_id' => $this->user->id,
            'movement_number' => 'MOV-API-001',
            'movement_type' => 'Stock In',
            'movement_date' => '2026-07-10',
            'quantity' => 1000,
            'unit_cost' => 12500,
            'total_cost' => 12500000,
            'reference_type' => 'Receiving',
        ])->assertCreated()
            ->assertJsonPath('data.movement_number', 'MOV-API-001');
    }

    public function test_stock_opname_detail_can_be_created(): void
    {
        $this->authenticate();

        $context = $this->createInventoryContext();
        $item = InventoryItem::factory()->create();
        $batch = InventoryBatch::factory()->create(['inventory_item_id' => $item->id]);
        InventoryStock::factory()->create([
            'inventory_item_id' => $item->id,
            'warehouse_location_id' => $batch->warehouse_location_id,
            'batch_id' => $batch->id,
        ]);

        $opnameResponse = $this->postJson(self::API_PREFIX.'/stock-opnames', [
            'warehouse_id' => $context['warehouse']->id,
            'user_id' => $this->user->id,
            'opname_number' => 'OPN-API-001',
            'opname_date' => '2026-07-10',
            'status' => 'Draft',
        ]);

        $opnameResponse->assertCreated()
            ->assertJsonPath('data.opname_number', 'OPN-API-001');

        $this->postJson(self::API_PREFIX.'/stock-opname-details', [
            'stock_opname_id' => $opnameResponse->json('data.id'),
            'inventory_item_id' => $item->id,
            'batch_id' => $batch->id,
            'system_quantity' => 100,
            'physical_quantity' => 98,
            'difference_quantity' => -2,
            'adjustment_required' => true,
        ])->assertCreated()
            ->assertJsonPath('data.adjustment_required', true);
    }

    public function test_warehouse_validation_rejects_missing_required_fields(): void
    {
        $this->authenticate();

        $this->postJson(self::API_PREFIX.'/warehouses', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'farm_id',
                'warehouse_code',
                'warehouse_name',
                'status',
            ]);
    }

    public function test_warehouse_restore_and_force_delete_flow(): void
    {
        $this->authenticate();

        $warehouse = Warehouse::factory()->create();
        $warehouse->delete();

        $this->postJson(self::API_PREFIX."/warehouses/{$warehouse->uuid}/restore")
            ->assertOk()
            ->assertJsonPath('message', 'Data restored successfully');

        $this->deleteJson(self::API_PREFIX."/warehouses/{$warehouse->uuid}/force")
            ->assertOk()
            ->assertJsonPath('message', 'Data permanently deleted');

        $this->assertDatabaseMissing('warehouses', ['uuid' => $warehouse->uuid]);
    }

    public function test_unauthenticated_user_cannot_access_warehouse_api(): void
    {
        $this->getJson(self::API_PREFIX.'/warehouses')
            ->assertUnauthorized();
    }

    private function authenticate(): void
    {
        Sanctum::actingAs($this->user);
    }

    private function createInventoryContext(): array
    {
        $farm = $this->createFarm();

        $warehouse = Warehouse::query()->create([
            'farm_id' => $farm->id,
            'warehouse_code' => 'WHS-CTX',
            'warehouse_name' => 'Context Warehouse',
            'status' => 'Active',
        ]);

        $location = WarehouseLocation::query()->create([
            'warehouse_id' => $warehouse->id,
            'location_code' => 'LOC-CTX',
            'location_name' => 'Context Location',
            'status' => 'Active',
        ]);

        $category = GeneralReference::query()->create([
            'reference_code' => 'INV-CTX',
            'reference_name' => 'Context Inventory',
            'reference_group' => 'inventory_category',
            'reference_value' => 'feed',
            'is_active' => true,
        ]);

        $unit = Unit::query()->create([
            'unit_code' => 'KG-CTX',
            'unit_name' => 'Kilogram Context',
        ]);

        $supplier = Supplier::query()->create([
            'supplier_code' => 'SUP-CTX',
            'supplier_name' => 'Context Supplier',
            'supplier_type' => 'feed',
        ]);

        return [
            'farm' => $farm,
            'warehouse' => $warehouse,
            'location' => $location,
            'category' => $category,
            'unit' => $unit,
            'supplier' => $supplier,
        ];
    }

    private function createFarm(): Farm
    {
        $company = Company::query()->create([
            'company_code' => 'CMP-'.str()->random(8),
            'company_name' => 'Warehouse Test Company',
        ]);

        return Farm::query()->create([
            'company_id' => $company->id,
            'farm_code' => 'FRM-'.str()->random(8),
            'farm_name' => 'Warehouse Test Farm',
        ]);
    }
}

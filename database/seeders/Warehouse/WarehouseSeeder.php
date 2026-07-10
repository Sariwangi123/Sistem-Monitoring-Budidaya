<?php

namespace Database\Seeders\Warehouse;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use MasterData\Models\Company;
use MasterData\Models\Farm;
use MasterData\Models\GeneralReference;
use MasterData\Models\Supplier;
use MasterData\Models\Unit;
use Modules\Users\Models\User;
use Warehouse\Models\InventoryBatch;
use Warehouse\Models\InventoryItem;
use Warehouse\Models\InventoryMovement;
use Warehouse\Models\InventoryStock;
use Warehouse\Models\StockOpname;
use Warehouse\Models\StockOpnameDetail;
use Warehouse\Models\Warehouse;
use Warehouse\Models\WarehouseLocation;

final class WarehouseSeeder extends Seeder
{
    public function run(): void
    {
        $company = Company::query()->firstOrCreate(
            ['company_code' => 'CMP-WHS'],
            ['company_name' => 'Warehouse Company']
        );

        $farm = Farm::query()->firstOrCreate(
            ['farm_code' => 'FRM-WHS'],
            ['company_id' => $company->id, 'farm_name' => 'Warehouse Farm']
        );

        $unit = Unit::query()->firstOrCreate(
            ['unit_code' => 'KG'],
            ['unit_name' => 'Kilogram']
        );

        $supplier = Supplier::query()->firstOrCreate(
            ['supplier_code' => 'SUP-WHS'],
            ['supplier_name' => 'Warehouse Supplier', 'supplier_type' => 'feed']
        );

        $user = User::query()->firstOrCreate(
            ['email' => 'warehouse.user@example.com'],
            ['name' => 'Warehouse User', 'password' => Hash::make('password'), 'is_active' => true]
        );

        $categories = collect([
            ['reference_code' => 'INV-FEED', 'reference_name' => 'Feed', 'reference_value' => 'feed'],
            ['reference_code' => 'INV-MEDICINE', 'reference_name' => 'Medicine', 'reference_value' => 'medicine'],
            ['reference_code' => 'INV-VITAMIN', 'reference_name' => 'Vitamin', 'reference_value' => 'vitamin'],
            ['reference_code' => 'INV-CHEMICAL', 'reference_name' => 'Chemical', 'reference_value' => 'chemical'],
            ['reference_code' => 'INV-EQUIPMENT', 'reference_name' => 'Equipment', 'reference_value' => 'equipment'],
        ])->map(fn (array $category) => GeneralReference::query()->firstOrCreate(
            ['reference_code' => $category['reference_code']],
            [
                'reference_name' => $category['reference_name'],
                'reference_group' => 'inventory_category',
                'reference_value' => $category['reference_value'],
                'is_active' => true,
            ]
        ));

        $warehouse = Warehouse::query()->firstOrCreate(
            ['warehouse_code' => 'WHS-MAIN'],
            [
                'farm_id' => $farm->id,
                'warehouse_name' => 'Main Warehouse',
                'description' => 'Primary operational warehouse.',
                'status' => 'Active',
            ]
        );

        $location = WarehouseLocation::query()->firstOrCreate(
            ['warehouse_id' => $warehouse->id, 'location_code' => 'LOC-FEED'],
            [
                'location_name' => 'Feed Storage',
                'description' => 'Main feed storage location.',
                'status' => 'Active',
            ]
        );

        $feedItem = InventoryItem::query()->firstOrCreate(
            ['item_code' => 'ITEM-FEED-STARTER'],
            [
                'item_category_id' => $categories->firstWhere('reference_code', 'INV-FEED')?->id,
                'unit_id' => $unit->id,
                'supplier_id' => $supplier->id,
                'item_name' => 'Starter Feed',
                'brand' => 'UtiFeed',
                'specification' => 'Starter pellet feed for early grow-out stage.',
                'minimum_stock' => 100,
                'maximum_stock' => 2000,
                'reorder_level' => 250,
                'status' => 'Active',
            ]
        );

        $batch = InventoryBatch::query()->firstOrCreate(
            ['inventory_item_id' => $feedItem->id, 'batch_number' => 'BATCH-FEED-001'],
            [
                'warehouse_location_id' => $location->id,
                'lot_number' => 'LOT-FEED-001',
                'production_date' => now()->subMonth()->toDateString(),
                'expired_date' => now()->addMonths(10)->toDateString(),
                'received_date' => now()->subWeek()->toDateString(),
                'status' => 'Available',
            ]
        );

        InventoryMovement::query()->firstOrCreate(
            ['movement_number' => 'MOV-STOCK-IN-001'],
            [
                'inventory_item_id' => $feedItem->id,
                'warehouse_id' => $warehouse->id,
                'warehouse_location_id' => $location->id,
                'batch_id' => $batch->id,
                'user_id' => $user->id,
                'movement_type' => 'Stock In',
                'movement_date' => now()->subWeek()->toDateString(),
                'quantity' => 1000,
                'unit_cost' => 12500,
                'total_cost' => 12500000,
                'reference_type' => 'Initial Stock',
                'notes' => 'Initial stock for Warehouse module seed.',
            ]
        );

        InventoryStock::query()->firstOrCreate(
            [
                'inventory_item_id' => $feedItem->id,
                'warehouse_location_id' => $location->id,
                'batch_id' => $batch->id,
            ],
            [
                'current_quantity' => 1000,
                'reserved_quantity' => 0,
                'available_quantity' => 1000,
                'last_movement_at' => now(),
            ]
        );

        $opname = StockOpname::query()->firstOrCreate(
            ['opname_number' => 'OPN-WHS-001'],
            [
                'warehouse_id' => $warehouse->id,
                'user_id' => $user->id,
                'opname_date' => now()->toDateString(),
                'status' => 'Draft',
                'notes' => 'Initial stock opname sample.',
            ]
        );

        StockOpnameDetail::query()->firstOrCreate(
            [
                'stock_opname_id' => $opname->id,
                'inventory_item_id' => $feedItem->id,
                'batch_id' => $batch->id,
            ],
            [
                'system_quantity' => 1000,
                'physical_quantity' => 1000,
                'difference_quantity' => 0,
                'adjustment_required' => false,
                'notes' => 'Seeded stock matches physical stock.',
            ]
        );
    }
}

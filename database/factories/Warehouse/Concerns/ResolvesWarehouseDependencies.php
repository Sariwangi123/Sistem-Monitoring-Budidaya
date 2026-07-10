<?php

namespace Database\Factories\Warehouse\Concerns;

use Illuminate\Support\Facades\Hash;
use MasterData\Models\Company;
use MasterData\Models\Farm;
use MasterData\Models\GeneralReference;
use MasterData\Models\Supplier;
use MasterData\Models\Unit;
use Modules\Users\Models\User;
use Warehouse\Models\InventoryBatch;
use Warehouse\Models\InventoryItem;
use Warehouse\Models\StockOpname;
use Warehouse\Models\Warehouse;
use Warehouse\Models\WarehouseLocation;

trait ResolvesWarehouseDependencies
{
    protected function farmId(): int
    {
        $company = Company::query()->first() ?? Company::query()->create([
            'company_code' => 'CMP-WHS',
            'company_name' => 'Warehouse Company',
        ]);

        $farm = Farm::query()->first() ?? Farm::query()->create([
            'company_id' => $company->id,
            'farm_code' => 'FRM-WHS',
            'farm_name' => 'Warehouse Farm',
        ]);

        return $farm->id;
    }

    protected function unitId(): int
    {
        $unit = Unit::query()->first() ?? Unit::query()->create([
            'unit_code' => 'KG',
            'unit_name' => 'Kilogram',
        ]);

        return $unit->id;
    }

    protected function supplierId(): int
    {
        $supplier = Supplier::query()->first() ?? Supplier::query()->create([
            'supplier_code' => 'SUP-WHS',
            'supplier_name' => 'Warehouse Supplier',
            'supplier_type' => 'feed',
        ]);

        return $supplier->id;
    }

    protected function itemCategoryId(): int
    {
        $category = GeneralReference::query()
            ->where('reference_group', 'inventory_category')
            ->first() ?? GeneralReference::query()->create([
                'reference_code' => 'INV-FEED',
                'reference_name' => 'Feed',
                'reference_group' => 'inventory_category',
                'reference_value' => 'feed',
                'is_active' => true,
            ]);

        return $category->id;
    }

    protected function userId(): int
    {
        $user = User::query()->first() ?? User::query()->create([
            'name' => 'Warehouse User',
            'email' => 'warehouse.user@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        return $user->id;
    }

    protected function warehouseId(): int
    {
        $warehouse = Warehouse::query()->first() ?? Warehouse::query()->create([
            'farm_id' => $this->farmId(),
            'warehouse_code' => 'WHS-MAIN',
            'warehouse_name' => 'Main Warehouse',
            'status' => 'Active',
        ]);

        return $warehouse->id;
    }

    protected function warehouseLocationId(): int
    {
        $location = WarehouseLocation::query()->first() ?? WarehouseLocation::query()->create([
            'warehouse_id' => $this->warehouseId(),
            'location_code' => 'LOC-MAIN',
            'location_name' => 'Main Location',
            'status' => 'Active',
        ]);

        return $location->id;
    }

    protected function inventoryItemId(): int
    {
        $item = InventoryItem::query()->first() ?? InventoryItem::query()->create([
            'item_category_id' => $this->itemCategoryId(),
            'unit_id' => $this->unitId(),
            'supplier_id' => $this->supplierId(),
            'item_code' => 'ITEM-FEED',
            'item_name' => 'Starter Feed',
            'minimum_stock' => 100,
            'maximum_stock' => 1000,
            'reorder_level' => 150,
            'status' => 'Active',
        ]);

        return $item->id;
    }

    protected function inventoryBatchId(): int
    {
        $batch = InventoryBatch::query()->first() ?? InventoryBatch::query()->create([
            'inventory_item_id' => $this->inventoryItemId(),
            'warehouse_location_id' => $this->warehouseLocationId(),
            'batch_number' => 'BATCH-WHS',
            'lot_number' => 'LOT-WHS',
            'received_date' => now()->toDateString(),
            'status' => 'Available',
        ]);

        return $batch->id;
    }

    protected function stockOpnameId(): int
    {
        $opname = StockOpname::query()->first() ?? StockOpname::query()->create([
            'warehouse_id' => $this->warehouseId(),
            'user_id' => $this->userId(),
            'opname_number' => 'OPN-WHS',
            'opname_date' => now()->toDateString(),
            'status' => 'Draft',
        ]);

        return $opname->id;
    }
}

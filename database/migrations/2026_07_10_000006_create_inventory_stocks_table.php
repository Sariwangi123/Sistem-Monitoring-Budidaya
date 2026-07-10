<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_stocks', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('inventory_item_id')->constrained('inventory_items')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('warehouse_location_id')->constrained('warehouse_locations')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('batch_id')->nullable()->constrained('inventory_batches')->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('current_quantity', 15, 2)->default(0);
            $table->decimal('reserved_quantity', 15, 2)->default(0);
            $table->decimal('available_quantity', 15, 2)->default(0);
            $table->timestamp('last_movement_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->unique(['inventory_item_id', 'warehouse_location_id', 'batch_id'], 'inventory_stock_unique');
            $table->index('uuid');
            $table->index('inventory_item_id');
            $table->index('warehouse_location_id');
            $table->index('batch_id');
            $table->index('last_movement_at');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_stocks');
    }
};

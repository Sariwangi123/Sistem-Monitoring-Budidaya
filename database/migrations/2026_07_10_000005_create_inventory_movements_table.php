<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_movements', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('inventory_item_id')->constrained('inventory_items')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('warehouse_id')->constrained('warehouses')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('warehouse_location_id')->constrained('warehouse_locations')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('batch_id')->nullable()->constrained('inventory_batches')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('culture_cycle_id')->nullable()->constrained('culture_cycles')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('activity_id')->nullable()->constrained('activities')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('movement_number')->unique();
            $table->string('movement_type');
            $table->date('movement_date');
            $table->decimal('quantity', 15, 2);
            $table->decimal('unit_cost', 15, 2)->default(0);
            $table->decimal('total_cost', 15, 2)->default(0);
            $table->string('reference_type')->nullable();
            $table->uuid('reference_uuid')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('uuid');
            $table->index('movement_number');
            $table->index('movement_type');
            $table->index('movement_date');
            $table->index('inventory_item_id');
            $table->index('warehouse_id');
            $table->index('warehouse_location_id');
            $table->index('batch_id');
            $table->index('reference_uuid');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};

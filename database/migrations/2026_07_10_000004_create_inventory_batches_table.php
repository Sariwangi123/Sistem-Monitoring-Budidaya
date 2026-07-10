<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_batches', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('inventory_item_id')->constrained('inventory_items')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('warehouse_location_id')->constrained('warehouse_locations')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('batch_number');
            $table->string('lot_number')->nullable();
            $table->date('production_date')->nullable();
            $table->date('expired_date')->nullable();
            $table->date('received_date')->nullable();
            $table->string('status')->default('Available');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->unique(['inventory_item_id', 'batch_number']);
            $table->index('uuid');
            $table->index('inventory_item_id');
            $table->index('warehouse_location_id');
            $table->index('batch_number');
            $table->index('lot_number');
            $table->index('expired_date');
            $table->index('status');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_batches');
    }
};

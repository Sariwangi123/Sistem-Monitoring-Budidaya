<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_opname_details', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('stock_opname_id')->constrained('stock_opnames')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('inventory_item_id')->constrained('inventory_items')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('batch_id')->nullable()->constrained('inventory_batches')->cascadeOnUpdate()->restrictOnDelete();
            $table->decimal('system_quantity', 15, 2)->default(0);
            $table->decimal('physical_quantity', 15, 2)->default(0);
            $table->decimal('difference_quantity', 15, 2)->default(0);
            $table->boolean('adjustment_required')->default(false);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('uuid');
            $table->index('stock_opname_id');
            $table->index('inventory_item_id');
            $table->index('batch_id');
            $table->index('adjustment_required');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_opname_details');
    }
};

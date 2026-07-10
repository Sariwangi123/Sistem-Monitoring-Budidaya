<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_items', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('item_category_id')->nullable()->constrained('general_references')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('unit_id')->constrained('units')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('item_code')->unique();
            $table->string('item_name');
            $table->string('brand')->nullable();
            $table->text('specification')->nullable();
            $table->decimal('minimum_stock', 15, 2)->default(0);
            $table->decimal('maximum_stock', 15, 2)->nullable();
            $table->decimal('reorder_level', 15, 2)->default(0);
            $table->string('status')->default('Active');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('uuid');
            $table->index('item_code');
            $table->index('item_name');
            $table->index('item_category_id');
            $table->index('unit_id');
            $table->index('supplier_id');
            $table->index('status');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_items');
    }
};

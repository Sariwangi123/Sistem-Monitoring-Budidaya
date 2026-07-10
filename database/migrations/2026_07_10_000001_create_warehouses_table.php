<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('warehouses', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('farm_id')->constrained('farms')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('warehouse_code')->unique();
            $table->string('warehouse_name');
            $table->text('description')->nullable();
            $table->string('status')->default('Active');
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('uuid');
            $table->index('farm_id');
            $table->index('warehouse_code');
            $table->index('warehouse_name');
            $table->index('status');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warehouses');
    }
};

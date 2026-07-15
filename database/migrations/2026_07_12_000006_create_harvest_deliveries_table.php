<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('harvest_deliveries', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('harvest_id')->constrained('harvests')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('harvest_packing_id')->nullable()->constrained('harvest_packings')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('customer_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('driver_user_id')->nullable()->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('delivery_code')->unique();
            $table->string('document_number')->unique();
            $table->date('delivery_date');
            $table->string('vehicle_number')->nullable();
            $table->string('driver_name')->nullable();
            $table->integer('package_quantity')->default(0);
            $table->decimal('delivered_weight', 15, 2)->default(0);
            $table->string('delivery_status')->default('Scheduled');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('uuid');
            $table->index('harvest_id');
            $table->index('harvest_packing_id');
            $table->index('customer_id');
            $table->index('driver_user_id');
            $table->index('delivery_code');
            $table->index('document_number');
            $table->index('delivery_date');
            $table->index('delivery_status');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harvest_deliveries');
    }
};

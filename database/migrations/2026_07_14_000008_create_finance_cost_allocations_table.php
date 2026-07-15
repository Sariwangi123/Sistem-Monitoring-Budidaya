<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finance_cost_allocations', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('ledger_id')->constrained('finance_ledgers')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('source_cost_center_id')->nullable()->constrained('finance_cost_centers')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('target_cost_center_id')->constrained('finance_cost_centers')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('culture_cycle_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('harvest_id')->nullable()->constrained('harvests')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('allocation_number')->unique();
            $table->date('allocation_date');
            $table->string('allocation_method');
            $table->decimal('allocation_percentage', 8, 4)->default(0);
            $table->decimal('allocated_amount', 18, 2)->default(0);
            $table->string('status')->default('Draft');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('uuid');
            $table->index('ledger_id');
            $table->index('source_cost_center_id');
            $table->index('target_cost_center_id');
            $table->index('culture_cycle_id');
            $table->index('harvest_id');
            $table->index('allocation_number');
            $table->index('allocation_date');
            $table->index('allocation_method');
            $table->index('status');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finance_cost_allocations');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finance_profit_calculations', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('farm_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('culture_cycle_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('harvest_id')->nullable()->constrained('harvests')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('cost_center_id')->constrained('finance_cost_centers')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('calculation_number')->unique();
            $table->date('calculation_date');
            $table->date('period_start');
            $table->date('period_end');
            $table->decimal('feed_cost', 18, 2)->default(0);
            $table->decimal('medicine_cost', 18, 2)->default(0);
            $table->decimal('labor_cost', 18, 2)->default(0);
            $table->decimal('utility_cost', 18, 2)->default(0);
            $table->decimal('maintenance_cost', 18, 2)->default(0);
            $table->decimal('operational_cost', 18, 2)->default(0);
            $table->decimal('cost_of_production', 18, 2)->default(0);
            $table->decimal('total_revenue', 18, 2)->default(0);
            $table->decimal('gross_profit', 18, 2)->default(0);
            $table->decimal('net_profit', 18, 2)->default(0);
            $table->decimal('harvest_weight', 15, 2)->default(0);
            $table->decimal('cost_per_kg', 18, 4)->default(0);
            $table->string('status')->default('Draft');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('uuid');
            $table->index('company_id');
            $table->index('farm_id');
            $table->index('culture_cycle_id');
            $table->index('harvest_id');
            $table->index('cost_center_id');
            $table->index('calculation_number');
            $table->index('calculation_date');
            $table->index(['period_start', 'period_end']);
            $table->index('status');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finance_profit_calculations');
    }
};

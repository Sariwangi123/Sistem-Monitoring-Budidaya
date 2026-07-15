<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('harvests', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('farm_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('pond_area_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('pond_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('culture_cycle_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('responsible_user_id')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('activity_id')->nullable()->constrained('activities')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('harvest_code')->unique();
            $table->string('harvest_name');
            $table->string('harvest_type');
            $table->date('planned_harvest_date')->nullable();
            $table->date('harvest_date');
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->integer('estimated_population')->nullable();
            $table->decimal('estimated_biomass', 15, 2)->default(0);
            $table->integer('total_harvest_population')->default(0);
            $table->decimal('total_harvest_weight', 15, 2)->default(0);
            $table->decimal('average_weight', 12, 4)->default(0);
            $table->decimal('survival_rate', 8, 4)->nullable();
            $table->decimal('feed_conversion_ratio', 8, 4)->nullable();
            $table->decimal('average_daily_gain', 12, 4)->nullable();
            $table->string('status')->default('Planning');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('uuid');
            $table->index('harvest_code');
            $table->index('harvest_type');
            $table->index('harvest_date');
            $table->index('planned_harvest_date');
            $table->index('company_id');
            $table->index('farm_id');
            $table->index('pond_area_id');
            $table->index('pond_id');
            $table->index('culture_cycle_id');
            $table->index('customer_id');
            $table->index('responsible_user_id');
            $table->index('activity_id');
            $table->index('status');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harvests');
    }
};

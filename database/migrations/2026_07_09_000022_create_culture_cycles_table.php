<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('culture_cycles', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('farm_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('pond_area_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('pond_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('fish_species_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('fish_strain_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('supplier_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('employee_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('cycle_code')->unique();
            $table->string('cycle_name');
            $table->date('stocking_date')->nullable();
            $table->date('estimated_harvest_date')->nullable();
            $table->date('actual_harvest_date')->nullable();
            $table->integer('initial_seed_quantity')->nullable();
            $table->integer('current_population')->nullable();
            $table->decimal('initial_average_weight', 12, 4)->nullable();
            $table->decimal('current_average_weight', 12, 4)->nullable();
            $table->decimal('current_biomass', 14, 4)->nullable();
            $table->string('status')->default('Draft');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('pond_id');
            $table->index('stocking_date');
            $table->index('status');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('culture_cycles');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('culture_cycle_water_qualities', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('culture_cycle_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->date('measurement_date');
            $table->decimal('temperature', 8, 2)->nullable();
            $table->decimal('ph', 8, 2)->nullable();
            $table->decimal('do', 8, 2)->nullable();
            $table->decimal('ammonia', 8, 4)->nullable();
            $table->decimal('nitrite', 8, 4)->nullable();
            $table->decimal('salinity', 8, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('culture_cycle_id');
            $table->index('measurement_date');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('culture_cycle_water_qualities');
    }
};
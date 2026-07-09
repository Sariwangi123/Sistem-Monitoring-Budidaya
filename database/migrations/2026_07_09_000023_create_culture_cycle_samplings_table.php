<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('culture_cycle_samplings', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('culture_cycle_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->date('sampling_date');
            $table->integer('sample_count')->nullable();
            $table->decimal('average_weight', 12, 4)->nullable();
            $table->decimal('average_length', 12, 4)->nullable();
            $table->decimal('biomass', 14, 4)->nullable();
            $table->decimal('adg', 12, 4)->nullable();
            $table->decimal('survival_rate', 8, 4)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('culture_cycle_id');
            $table->index('sampling_date');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('culture_cycle_samplings');
    }
};
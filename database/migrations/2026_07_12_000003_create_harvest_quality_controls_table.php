<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('harvest_quality_controls', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('harvest_id')->constrained('harvests')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('harvest_batch_id')->constrained('harvest_batches')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('qc_user_id')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->date('qc_date');
            $table->decimal('average_weight', 12, 4)->default(0);
            $table->string('fish_size')->nullable();
            $table->string('fish_condition')->nullable();
            $table->decimal('damage_rate', 8, 4)->default(0);
            $table->string('qc_status')->default('Passed');
            $table->text('qc_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('uuid');
            $table->index('harvest_id');
            $table->index('harvest_batch_id');
            $table->index('qc_user_id');
            $table->index('qc_date');
            $table->index('qc_status');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harvest_quality_controls');
    }
};

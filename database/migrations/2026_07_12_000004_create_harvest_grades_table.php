<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('harvest_grades', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('harvest_id')->constrained('harvests')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('harvest_batch_id')->constrained('harvest_batches')->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('grade_code');
            $table->string('grade_name');
            $table->integer('fish_count')->default(0);
            $table->decimal('total_weight', 15, 2)->default(0);
            $table->decimal('average_weight', 12, 4)->default(0);
            $table->string('quality_status')->default('Accepted');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->unique(['harvest_batch_id', 'grade_code']);
            $table->index('uuid');
            $table->index('harvest_id');
            $table->index('harvest_batch_id');
            $table->index('grade_code');
            $table->index('grade_name');
            $table->index('quality_status');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harvest_grades');
    }
};

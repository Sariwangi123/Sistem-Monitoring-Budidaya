<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('harvest_packings', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('harvest_id')->constrained('harvests')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('harvest_batch_id')->constrained('harvest_batches')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('harvest_grade_id')->nullable()->constrained('harvest_grades')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('operator_user_id')->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('packing_code')->unique();
            $table->date('packing_date');
            $table->string('package_type');
            $table->integer('package_quantity')->default(0);
            $table->decimal('net_weight', 15, 2)->default(0);
            $table->decimal('gross_weight', 15, 2)->default(0);
            $table->string('status')->default('Packed');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('uuid');
            $table->index('harvest_id');
            $table->index('harvest_batch_id');
            $table->index('harvest_grade_id');
            $table->index('operator_user_id');
            $table->index('packing_code');
            $table->index('packing_date');
            $table->index('status');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harvest_packings');
    }
};

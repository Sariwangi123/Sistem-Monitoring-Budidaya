<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('farm_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('pond_area_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('pond_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('culture_cycle_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('activity_type_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->date('activity_date');
            $table->time('activity_time');
            $table->string('event_code');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('status')->default('Completed');
            $table->string('reference_type')->nullable();
            $table->uuid('reference_uuid')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('uuid');
            $table->index('event_code');
            $table->index('activity_date');
            $table->index('culture_cycle_id');
            $table->index('user_id');
            $table->index('activity_type_id');
            $table->index('status');
            $table->index('reference_type');
            $table->index('reference_uuid');
            $table->index('deleted_at');
            $table->index(['culture_cycle_id', 'activity_date']);
            $table->index(['company_id', 'farm_id', 'pond_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
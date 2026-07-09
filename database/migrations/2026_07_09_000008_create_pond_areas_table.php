<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pond_areas', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('farm_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('pond_area_code')->unique();
            $table->string('pond_area_name');
            $table->decimal('area_size', 12, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('farm_id');
            $table->index('pond_area_name');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pond_areas');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ponds', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('pond_area_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('pond_code')->unique();
            $table->string('pond_name');
            $table->decimal('area_size', 12, 2)->nullable();
            $table->decimal('depth', 8, 2)->nullable();
            $table->decimal('volume', 12, 2)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('pond_area_id');
            $table->index('pond_name');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ponds');
    }
};
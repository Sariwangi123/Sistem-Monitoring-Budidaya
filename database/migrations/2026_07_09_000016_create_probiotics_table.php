<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('probiotics', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('probiotic_code')->unique();
            $table->string('probiotic_name');
            $table->string('bacterial_strain')->nullable();
            $table->string('manufacturer')->nullable();
            $table->decimal('packaging_size', 10, 2)->nullable();
            $table->foreignId('packaging_unit_id')->nullable()->constrained('units')->cascadeOnUpdate()->restrictOnDelete();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('probiotic_name');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('probiotics');
    }
};
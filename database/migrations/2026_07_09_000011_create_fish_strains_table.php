<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fish_strains', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('fish_species_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('fish_strain_code')->unique();
            $table->string('fish_strain_name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('fish_species_id');
            $table->index('fish_strain_name');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fish_strains');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('general_references', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('reference_code')->unique();
            $table->string('reference_name');
            $table->string('reference_group');
            $table->string('reference_value')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('reference_group');
            $table->index('reference_name');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('general_references');
    }
};
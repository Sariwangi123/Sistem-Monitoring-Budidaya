<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_types', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('event_code')->unique();
            $table->string('activity_name');
            $table->foreignId('activity_category_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('icon')->nullable();
            $table->string('color')->nullable();
            $table->boolean('is_manual')->default(true);
            $table->boolean('is_system')->default(false);
            $table->string('status')->default('Active');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('event_code');
            $table->index('activity_category_id');
            $table->index('status');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_types');
    }
};
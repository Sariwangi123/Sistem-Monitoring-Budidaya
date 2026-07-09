<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_attachments', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('activity_id')->constrained()->cascadeOnUpdate()->cascadeOnDelete();
            $table->string('file_name');
            $table->string('file_type');
            $table->bigInteger('file_size');
            $table->string('storage_path');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('activity_id');
            $table->index('file_type');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_attachments');
    }
};
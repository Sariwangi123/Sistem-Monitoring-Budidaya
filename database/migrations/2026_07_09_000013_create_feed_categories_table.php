<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feed_categories', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('feed_category_code')->unique();
            $table->string('feed_category_name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('feed_category_name');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_categories');
    }
};
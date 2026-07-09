<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('feed_types', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('feed_brand_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('feed_category_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('feed_type_code')->unique();
            $table->string('feed_type_name');
            $table->decimal('protein_content', 6, 2)->nullable();
            $table->decimal('fat_content', 6, 2)->nullable();
            $table->decimal('fiber_content', 6, 2)->nullable();
            $table->decimal('moisture', 6, 2)->nullable();
            $table->decimal('ash_content', 6, 2)->nullable();
            $table->decimal('pellet_size', 8, 2)->nullable();
            $table->decimal('packaging_size', 10, 2)->nullable();
            $table->foreignId('packaging_unit_id')->nullable()->constrained('units')->cascadeOnUpdate()->restrictOnDelete();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index(['feed_brand_id', 'feed_category_id']);
            $table->index('feed_type_name');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed_types');
    }
};
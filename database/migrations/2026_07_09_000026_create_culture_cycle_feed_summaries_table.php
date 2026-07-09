<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('culture_cycle_feed_summaries', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('culture_cycle_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('feed_id')->constrained('feed_types')->cascadeOnUpdate()->restrictOnDelete();
            $table->date('feeding_date');
            $table->decimal('feed_quantity', 14, 4);
            $table->integer('feeding_frequency')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('culture_cycle_id');
            $table->index('feeding_date');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('culture_cycle_feed_summaries');
    }
};
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('harvest_batches', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('harvest_id')->constrained('harvests')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('culture_cycle_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('batch_code')->unique();
            $table->string('batch_name');
            $table->date('harvest_date');
            $table->integer('harvest_population')->default(0);
            $table->decimal('gross_weight', 15, 2)->default(0);
            $table->decimal('net_weight', 15, 2)->default(0);
            $table->decimal('average_weight', 12, 4)->default(0);
            $table->string('status')->default('Harvesting');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('uuid');
            $table->index('harvest_id');
            $table->index('culture_cycle_id');
            $table->index('batch_code');
            $table->index('harvest_date');
            $table->index('status');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harvest_batches');
    }
};

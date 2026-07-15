<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_histories', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('notification_record_id')->constrained('notification_records')->cascadeOnDelete();
            $table->string('event_name')->index();
            $table->string('channel')->index();
            $table->string('recipient_type')->index();
            $table->string('recipient_id')->index();
            $table->string('status')->index();
            $table->unsignedSmallInteger('attempt')->default(1);
            $table->json('metadata')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_histories');
    }
};

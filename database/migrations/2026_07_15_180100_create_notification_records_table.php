<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notification_records', function (Blueprint $table): void {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('event_name')->index();
            $table->string('source_module')->index();
            $table->uuid('correlation_id')->index();
            $table->string('notification_type')->index();
            $table->string('category')->index();
            $table->string('priority')->index();
            $table->string('channel')->index();
            $table->string('recipient_type')->index();
            $table->string('recipient_id')->index();
            $table->string('title');
            $table->text('message');
            $table->string('action_url')->nullable();
            $table->string('status')->default('pending')->index();
            $table->unsignedSmallInteger('attempts')->default(0);
            $table->unsignedSmallInteger('max_attempts')->default(3);
            $table->text('last_error')->nullable();
            $table->json('metadata')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamp('archived_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->index(['event_name', 'status']);
            $table->index(['recipient_type', 'recipient_id', 'status'], 'notification_records_recipient_status_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notification_records');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finance_journal_entries', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('journal_id')->constrained('finance_journals')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('ledger_id')->nullable()->constrained('finance_ledgers')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('cost_center_id')->nullable()->constrained('finance_cost_centers')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('account_code');
            $table->string('account_name');
            $table->string('entry_type');
            $table->decimal('debit_amount', 18, 2)->default(0);
            $table->decimal('credit_amount', 18, 2)->default(0);
            $table->integer('line_order')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('uuid');
            $table->index('journal_id');
            $table->index('ledger_id');
            $table->index('cost_center_id');
            $table->index('account_code');
            $table->index('entry_type');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finance_journal_entries');
    }
};

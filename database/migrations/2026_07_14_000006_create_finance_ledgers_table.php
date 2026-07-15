<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finance_ledgers', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('farm_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('culture_cycle_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('cost_center_id')->constrained('finance_cost_centers')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('expense_id')->nullable()->constrained('finance_expenses')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('revenue_id')->nullable()->constrained('finance_revenues')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('journal_id')->nullable()->constrained('finance_journals')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('ledger_number')->unique();
            $table->string('document_number');
            $table->date('ledger_date');
            $table->string('ledger_type');
            $table->string('account_code')->nullable();
            $table->string('account_name')->nullable();
            $table->decimal('debit_amount', 18, 2)->default(0);
            $table->decimal('credit_amount', 18, 2)->default(0);
            $table->decimal('balance_amount', 18, 2)->default(0);
            $table->string('currency', 3)->default('IDR');
            $table->string('source_type')->nullable();
            $table->uuid('source_uuid')->nullable();
            $table->dateTime('posted_at')->nullable();
            $table->string('status')->default('Draft');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('uuid');
            $table->index('company_id');
            $table->index('farm_id');
            $table->index('culture_cycle_id');
            $table->index('cost_center_id');
            $table->index('expense_id');
            $table->index('revenue_id');
            $table->index('journal_id');
            $table->index('ledger_number');
            $table->index('document_number');
            $table->index('ledger_date');
            $table->index('ledger_type');
            $table->index('source_uuid');
            $table->index('posted_at');
            $table->index('status');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finance_ledgers');
    }
};

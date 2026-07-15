<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finance_expenses', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('farm_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('culture_cycle_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('cost_center_id')->constrained('finance_cost_centers')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('expense_category_id')->nullable()->constrained('general_references')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('activity_id')->nullable()->constrained('activities')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('inventory_movement_id')->nullable()->constrained('inventory_movements')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('expense_number')->unique();
            $table->string('document_number')->unique();
            $table->date('expense_date');
            $table->string('expense_type');
            $table->string('payment_method')->nullable();
            $table->decimal('amount', 18, 2)->default(0);
            $table->decimal('tax_amount', 18, 2)->default(0);
            $table->decimal('total_amount', 18, 2)->default(0);
            $table->string('currency', 3)->default('IDR');
            $table->string('source_type')->nullable();
            $table->uuid('source_uuid')->nullable();
            $table->string('status')->default('Draft');
            $table->text('notes')->nullable();
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
            $table->index('expense_category_id');
            $table->index('supplier_id');
            $table->index('activity_id');
            $table->index('inventory_movement_id');
            $table->index('expense_number');
            $table->index('document_number');
            $table->index('expense_date');
            $table->index('expense_type');
            $table->index('source_uuid');
            $table->index('status');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finance_expenses');
    }
};

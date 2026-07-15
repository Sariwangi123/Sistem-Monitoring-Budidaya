<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('finance_revenues', function (Blueprint $table): void {
            $table->id();
            $table->uuid()->unique();
            $table->foreignId('company_id')->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('farm_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('culture_cycle_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('cost_center_id')->constrained('finance_cost_centers')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('revenue_category_id')->nullable()->constrained('general_references')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('harvest_id')->nullable()->constrained('harvests')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('harvest_delivery_id')->nullable()->constrained('harvest_deliveries')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->string('revenue_number')->unique();
            $table->string('document_number')->unique();
            $table->date('revenue_date');
            $table->string('revenue_type');
            $table->decimal('quantity', 15, 2)->default(0);
            $table->decimal('unit_price', 18, 2)->default(0);
            $table->decimal('amount', 18, 2)->default(0);
            $table->decimal('tax_amount', 18, 2)->default(0);
            $table->decimal('discount_amount', 18, 2)->default(0);
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
            $table->index('revenue_category_id');
            $table->index('harvest_id');
            $table->index('harvest_delivery_id');
            $table->index('customer_id');
            $table->index('revenue_number');
            $table->index('document_number');
            $table->index('revenue_date');
            $table->index('revenue_type');
            $table->index('source_uuid');
            $table->index('status');
            $table->index('created_at');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('finance_revenues');
    }
};

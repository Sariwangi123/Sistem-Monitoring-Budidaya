<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('company_code')->unique();
            $table->string('company_name')->unique();
            $table->string('legal_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('tax_number')->nullable();
            $table->text('address')->nullable();
            $table->foreignId('province_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('city_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('district_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('village_id')->nullable()->constrained()->cascadeOnUpdate()->restrictOnDelete();
            $table->string('postal_code')->nullable();
            $table->string('logo')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->index('company_code');
            $table->index('company_name');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
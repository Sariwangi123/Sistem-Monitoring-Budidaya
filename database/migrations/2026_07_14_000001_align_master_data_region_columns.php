<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('districts', function (Blueprint $table): void {
            if (! Schema::hasColumn('districts', 'district_code')) {
                $table->string('district_code', 20)->unique()->after('city_id');
                $table->index('district_code');
            }
        });

        Schema::table('villages', function (Blueprint $table): void {
            if (! Schema::hasColumn('villages', 'village_code')) {
                $table->string('village_code', 20)->unique()->after('district_id');
                $table->index('village_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('villages', function (Blueprint $table): void {
            if (Schema::hasColumn('villages', 'village_code')) {
                $table->dropIndex(['village_code']);
                $table->dropColumn('village_code');
            }
        });

        Schema::table('districts', function (Blueprint $table): void {
            if (Schema::hasColumn('districts', 'district_code')) {
                $table->dropIndex(['district_code']);
                $table->dropColumn('district_code');
            }
        });
    }
};

<?php

namespace Database\Seeders\Activities;

use Activities\Models\Activity;
use Activities\Models\ActivityAttachment;
use Activities\Models\ActivityCategory;
use Activities\Models\ActivityComment;
use Activities\Models\ActivityType;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ActivitiesSeeder extends Seeder
{
    public function run(): void
    {
        // Create Activity Categories
        $categories = [
            ['category_code' => 'CAT-FEED', 'category_name' => 'Feeding', 'description' => 'Aktivitas pemberian pakan', 'status' => 'Active'],
            ['category_code' => 'CAT-SAMP', 'category_name' => 'Sampling', 'description' => 'Aktivitas sampling ikan', 'status' => 'Active'],
            ['category_code' => 'CAT-WATER', 'category_name' => 'Water Quality', 'description' => 'Aktivitas pengecekan kualitas air', 'status' => 'Active'],
            ['category_code' => 'CAT-HARV', 'category_name' => 'Harvest', 'description' => 'Aktivitas panen', 'status' => 'Active'],
            ['category_code' => 'CAT-MAINT', 'category_name' => 'Maintenance', 'description' => 'Aktivitas pemeliharaan tambak', 'status' => 'Active'],
        ];

        foreach ($categories as $cat) {
            ActivityCategory::query()->create($cat);
        }

        // Create Activity Types
        $types = [
            ['activity_category_id' => 1, 'event_code' => 'EVT-MANUAL-FEED', 'activity_name' => 'Manual Feeding', 'icon' => 'feed', 'color' => '#4CAF50', 'is_manual' => true, 'is_system' => false, 'status' => 'Active', 'description' => 'Pemberian pakan secara manual'],
            ['activity_category_id' => 1, 'event_code' => 'EVT-AUTO-FEED', 'activity_name' => 'Auto Feeding', 'icon' => 'feed', 'color' => '#8BC34A', 'is_manual' => false, 'is_system' => true, 'status' => 'Active', 'description' => 'Pemberian pakan otomatis'],
            ['activity_category_id' => 2, 'event_code' => 'EVT-SAMPLING', 'activity_name' => 'Sampling Routine', 'icon' => 'sampling', 'color' => '#2196F3', 'is_manual' => true, 'is_system' => false, 'status' => 'Active', 'description' => 'Sampling rutin'],
            ['activity_category_id' => 3, 'event_code' => 'EVT-WATER-TEST', 'activity_name' => 'Water Quality Test', 'icon' => 'water', 'color' => '#00BCD4', 'is_manual' => true, 'is_system' => false, 'status' => 'Active', 'description' => 'Pengecekan kualitas air'],
            ['activity_category_id' => 4, 'event_code' => 'EVT-PARTIAL-HARV', 'activity_name' => 'Partial Harvest', 'icon' => 'harvest', 'color' => '#FF9800', 'is_manual' => true, 'is_system' => false, 'status' => 'Active', 'description' => 'Panen parsial'],
            ['activity_category_id' => 5, 'event_code' => 'EVT-MAINT-POND', 'activity_name' => 'Pond Maintenance', 'icon' => 'maintenance', 'color' => '#9E9E9E', 'is_manual' => true, 'is_system' => false, 'status' => 'Active', 'description' => 'Pemeliharaan tambak'],
        ];

        foreach ($types as $type) {
            ActivityType::query()->create($type);
        }

        // Create Activities
        $activity = Activity::query()->create([
            'company_id' => 1,
            'farm_id' => 1,
            'pond_area_id' => 1,
            'pond_id' => 1,
            'culture_cycle_id' => 1,
            'activity_type_id' => 1,
            'user_id' => 1,
            'activity_date' => Carbon::now()->subDays(5),
            'activity_time' => Carbon::now()->subDays(5)->setTime(7, 0, 0),
            'event_code' => 'ACT-' . strtoupper(Str::random(10)),
            'title' => 'Pemberian Pakan Pagi - Tambak 1',
            'description' => 'Pemberian pakan pelet sebanyak 50 kg di tambak 1 pada pagi hari',
            'status' => 'Completed',
            'reference_type' => 'feeding',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Activity::query()->create([
            'company_id' => 1,
            'farm_id' => 1,
            'pond_area_id' => 1,
            'pond_id' => 1,
            'culture_cycle_id' => 1,
            'activity_type_id' => 2,
            'user_id' => 1,
            'activity_date' => Carbon::now()->subDays(4),
            'activity_time' => Carbon::now()->subDays(4)->setTime(12, 0, 0),
            'event_code' => 'ACT-' . strtoupper(Str::random(10)),
            'title' => 'Pemberian Pakan Siang - Tambak 1',
            'description' => 'Pemberian pakan pelet otomatis sebanyak 30 kg',
            'status' => 'Completed',
            'reference_type' => 'feeding',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Activity::query()->create([
            'company_id' => 1,
            'farm_id' => 1,
            'pond_area_id' => 1,
            'pond_id' => 1,
            'culture_cycle_id' => 1,
            'activity_type_id' => 3,
            'user_id' => 1,
            'activity_date' => Carbon::now()->subDays(3),
            'activity_time' => Carbon::now()->subDays(3)->setTime(8, 0, 0),
            'event_code' => 'ACT-' . strtoupper(Str::random(10)),
            'title' => 'Sampling Mingguan - Tambak 1',
            'description' => 'Sampling 100 ekor ikan untuk mengukur pertumbuhan',
            'status' => 'Completed',
            'reference_type' => 'sampling',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Activity::query()->create([
            'company_id' => 1,
            'farm_id' => 1,
            'pond_area_id' => 1,
            'pond_id' => 1,
            'culture_cycle_id' => 1,
            'activity_type_id' => 4,
            'user_id' => 1,
            'activity_date' => Carbon::now()->subDays(2),
            'activity_time' => Carbon::now()->subDays(2)->setTime(7, 30, 0),
            'event_code' => 'ACT-' . strtoupper(Str::random(10)),
            'title' => 'Cek Kualitas Air Rutin',
            'description' => 'Pengukuran suhu, pH, DO, dan parameter kualitas air lainnya',
            'status' => 'Completed',
            'reference_type' => 'water_quality',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        Activity::query()->create([
            'company_id' => 1,
            'farm_id' => 1,
            'pond_area_id' => 1,
            'pond_id' => 1,
            'culture_cycle_id' => 1,
            'activity_type_id' => 5,
            'user_id' => 1,
            'activity_date' => Carbon::now()->subDay(),
            'activity_time' => Carbon::now()->subDay()->setTime(6, 0, 0),
            'event_code' => 'ACT-' . strtoupper(Str::random(10)),
            'title' => 'Persiapan Panen Parsial',
            'description' => 'Persiapan alat dan tenaga untuk panen parsial tambak 1',
            'status' => 'Completed',
            'reference_type' => 'harvest',
            'created_by' => 1,
            'updated_by' => 1,
        ]);

        // Create Comments
        ActivityComment::query()->create([
            'activity_id' => $activity->id,
            'user_id' => 1,
            'comment' => 'Pakan habis dikonsumsi ikan dalam waktu 30 menit. Kondisi ikan sehat.',
        ]);

        ActivityComment::query()->create([
            'activity_id' => $activity->id,
            'user_id' => 1,
            'comment' => 'Perlu tambahan pakan 5 kg untuk minggu depan sesuai growth rate.',
        ]);

        // Create Attachments
        ActivityAttachment::query()->create([
            'activity_id' => $activity->id,
            'file_name' => 'foto_pagi_1.jpg',
            'file_type' => 'image/jpeg',
            'file_size' => 2048576,
            'storage_path' => 'uploads/activities/' . Str::uuid() . '/foto_pagi_1.jpg',
            'description' => 'Dokumentasi pemberian pakan pagi',
        ]);

        ActivityAttachment::query()->create([
            'activity_id' => $activity->id,
            'file_name' => 'laporan_feeding.xlsx',
            'file_type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'file_size' => 512000,
            'storage_path' => 'uploads/activities/' . Str::uuid() . '/laporan_feeding.xlsx',
            'description' => 'Laporan detail pemberian pakan',
        ]);
    }
}
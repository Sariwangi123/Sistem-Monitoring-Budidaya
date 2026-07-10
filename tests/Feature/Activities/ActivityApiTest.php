<?php

namespace Tests\Feature\Activities;

use Activities\Models\Activity;
use Activities\Models\ActivityCategory;
use Activities\Models\ActivityType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use MasterData\Models\Company;
use MasterData\Models\Farm;
use MasterData\Models\Pond;
use MasterData\Models\PondArea;
use Modules\Users\Models\User;
use Tests\TestCase;

final class ActivityApiTest extends TestCase
{
    use RefreshDatabase;

    private const API_PREFIX = '/api/v1';

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::query()->create([
            'name' => 'Activity Tester',
            'email' => 'activity.tester@example.com',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

    }

    public function test_activity_category_crud_flow(): void
    {
        $this->authenticate();

        $createResponse = $this->postJson(self::API_PREFIX.'/activities/categories', [
            'category_code' => 'ACT-CAT-001',
            'category_name' => 'Production',
            'description' => 'Production activity category.',
            'status' => 'Active',
        ]);

        $createResponse->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.category_code', 'ACT-CAT-001');

        $uuid = $createResponse->json('data.uuid');

        $this->getJson(self::API_PREFIX."/activities/categories/{$uuid}")
            ->assertOk()
            ->assertJsonPath('data.category_name', 'Production');

        $this->putJson(self::API_PREFIX."/activities/categories/{$uuid}", [
            'category_code' => 'ACT-CAT-001',
            'category_name' => 'Production Updated',
            'status' => 'Active',
        ])->assertOk()
            ->assertJsonPath('data.category_name', 'Production Updated');

        $this->deleteJson(self::API_PREFIX."/activities/categories/{$uuid}")
            ->assertOk()
            ->assertJsonPath('success', true);

        $this->assertSoftDeleted('activity_categories', ['uuid' => $uuid]);
    }

    public function test_activity_type_requires_existing_category(): void
    {
        $this->authenticate();

        $this->postJson(self::API_PREFIX.'/activities/types', [
            'event_code' => 'ACT-001',
            'activity_name' => 'Feeding Recorded',
            'activity_category_id' => 999,
            'status' => 'Active',
        ])->assertUnprocessable()
            ->assertJsonValidationErrors(['activity_category_id']);
    }

    public function test_activity_type_can_be_created(): void
    {
        $this->authenticate();

        $category = $this->createActivityCategory();

        $this->postJson(self::API_PREFIX.'/activities/types', [
            'event_code' => 'ACT-001',
            'activity_name' => 'Feeding Recorded',
            'activity_category_id' => $category->id,
            'is_manual' => true,
            'is_system' => false,
            'status' => 'Active',
        ])->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.event_code', 'ACT-001')
            ->assertJsonPath('data.activity_category_id', $category->id);
    }

    public function test_activity_can_be_created_listed_searched_and_deleted(): void
    {
        $this->authenticate();

        $context = $this->createActivityContext();

        $payload = [
            'company_id' => $context['company']->id,
            'farm_id' => $context['farm']->id,
            'pond_area_id' => $context['pond_area']->id,
            'pond_id' => $context['pond']->id,
            'culture_cycle_id' => null,
            'activity_type_id' => $context['activity_type']->id,
            'user_id' => $this->user->id,
            'activity_date' => '2026-07-10',
            'activity_time' => '08:30:00',
            'event_code' => 'ACT-FEED-001',
            'title' => 'Morning feeding recorded',
            'description' => 'Feed was applied according to schedule.',
            'status' => 'Completed',
            'reference_type' => 'Feeding',
            'reference_uuid' => '6bd86aa1-6022-44f9-bab2-29aa7572ef98',
            'metadata' => ['feed_quantity' => 12.5],
        ];

        $createResponse = $this->postJson(self::API_PREFIX.'/activities', $payload);

        $createResponse->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.event_code', 'ACT-FEED-001')
            ->assertJsonPath('data.title', 'Morning feeding recorded');

        $uuid = $createResponse->json('data.uuid');

        $this->getJson(self::API_PREFIX.'/activities?search=Morning')
            ->assertOk()
            ->assertJsonPath('data.0.event_code', 'ACT-FEED-001');

        $this->getJson(self::API_PREFIX.'/activities?per_page=5')
            ->assertOk();

        $this->deleteJson(self::API_PREFIX."/activities/{$uuid}")
            ->assertOk()
            ->assertJsonPath('message', 'Data deleted successfully');

        $this->assertSoftDeleted('activities', ['uuid' => $uuid]);
    }

    public function test_activity_validation_rejects_missing_required_fields(): void
    {
        $this->authenticate();

        $this->postJson(self::API_PREFIX.'/activities', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors([
                'company_id',
                'farm_id',
                'pond_area_id',
                'pond_id',
                'activity_type_id',
                'user_id',
                'activity_date',
                'activity_time',
                'event_code',
                'title',
                'status',
            ]);
    }

    public function test_activity_restore_and_force_delete_flow(): void
    {
        $this->authenticate();

        $activity = $this->createActivityContext()['activity'];
        $activity->delete();

        $this->postJson(self::API_PREFIX."/activities/{$activity->uuid}/restore")
            ->assertOk()
            ->assertJsonPath('message', 'Data restored successfully');

        $this->deleteJson(self::API_PREFIX."/activities/{$activity->uuid}/force")
            ->assertOk()
            ->assertJsonPath('message', 'Data permanently deleted');

        $this->assertDatabaseMissing('activities', ['uuid' => $activity->uuid]);
    }

    public function test_unauthenticated_user_cannot_access_activities(): void
    {
        $this->getJson(self::API_PREFIX.'/activities')
            ->assertUnauthorized();
    }

    private function authenticate(): void
    {
        Sanctum::actingAs($this->user);
    }

    private function createActivityContext(): array
    {
        $company = Company::query()->create([
            'company_code' => 'CMP-ACT',
            'company_name' => 'Activity Company',
        ]);

        $farm = Farm::query()->create([
            'company_id' => $company->id,
            'farm_code' => 'FRM-ACT',
            'farm_name' => 'Activity Farm',
        ]);

        $pondArea = PondArea::query()->create([
            'farm_id' => $farm->id,
            'pond_area_code' => 'AREA-ACT',
            'pond_area_name' => 'Activity Area',
        ]);

        $pond = Pond::query()->create([
            'pond_area_id' => $pondArea->id,
            'pond_code' => 'PND-ACT',
            'pond_name' => 'Activity Pond',
        ]);

        $activityType = ActivityType::query()->create([
            'activity_category_id' => $this->createActivityCategory()->id,
            'event_code' => 'ACT-TYPE-001',
            'activity_name' => 'Manual Activity',
            'is_manual' => true,
            'is_system' => false,
            'status' => 'Active',
        ]);

        $activity = Activity::query()->create([
            'company_id' => $company->id,
            'farm_id' => $farm->id,
            'pond_area_id' => $pondArea->id,
            'pond_id' => $pond->id,
            'activity_type_id' => $activityType->id,
            'user_id' => $this->user->id,
            'activity_date' => '2026-07-10',
            'activity_time' => '07:00:00',
            'event_code' => 'ACT-SEED-001',
            'title' => 'Seed activity',
            'status' => 'Completed',
        ]);

        return [
            'company' => $company,
            'farm' => $farm,
            'pond_area' => $pondArea,
            'pond' => $pond,
            'activity_type' => $activityType,
            'activity' => $activity,
        ];
    }

    private function createActivityCategory(): ActivityCategory
    {
        return ActivityCategory::query()->create([
            'category_code' => 'CAT-'.str()->random(8),
            'category_name' => 'Operational '.str()->random(6),
            'status' => 'Active',
        ]);
    }
}

<?php

namespace Tests\Feature\Notifications;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Sanctum\Sanctum;
use Modules\Notifications\Models\NotificationRecord;
use Modules\Roles\Models\Role;
use Modules\Users\Models\User;
use Tests\TestCase;

final class NotificationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_list_show_read_archive_and_delete_own_notification(): void
    {
        $user = $this->authenticateAs('farm-manager');
        $record = $this->notificationForUser($user, ['status' => 'delivered']);
        $otherUser = $this->createUserWithRole('viewer');
        $otherRecord = $this->notificationForUser($otherUser, ['title' => 'Other notification']);

        $this->getJson('/api/v1/notifications?unread_only=1')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.id', $record->uuid);

        $this->getJson('/api/v1/notifications/'.$record->uuid)
            ->assertOk()
            ->assertJsonPath('data.id', $record->uuid);

        $this->getJson('/api/v1/notifications/'.$otherRecord->uuid)
            ->assertNotFound();

        $this->patchJson('/api/v1/notifications/'.$record->uuid.'/read')
            ->assertOk()
            ->assertJsonPath('data.status', 'read');

        $this->patchJson('/api/v1/notifications/'.$record->uuid.'/archive')
            ->assertOk()
            ->assertJsonPath('data.status', 'archived');

        $this->deleteJson('/api/v1/notifications/'.$record->uuid)
            ->assertOk()
            ->assertJsonPath('data.deleted', true);
    }

    public function test_preferences_statistics_history_search_and_export_metadata_are_available(): void
    {
        $user = $this->authenticateAs('warehouse-staff');
        $this->notificationForRole('warehouse-staff', ['title' => 'Low feed stock', 'status' => 'delivered']);

        $this->getJson('/api/v1/notifications/search?search=feed')
            ->assertOk()
            ->assertJsonCount(1, 'data');

        $this->getJson('/api/v1/notifications/statistics')
            ->assertOk()
            ->assertJsonPath('data.total_notification', 1);

        $this->getJson('/api/v1/notifications/history')
            ->assertOk();

        $this->getJson('/api/v1/notifications/preferences')
            ->assertOk()
            ->assertJsonPath('data.in_app_enabled', true);

        $this->putJson('/api/v1/notifications/preferences', [
            'in_app_enabled' => true,
            'email_enabled' => true,
            'whatsapp_enabled' => true,
        ])
            ->assertOk()
            ->assertJsonPath('data.email_enabled', false)
            ->assertJsonPath('data.whatsapp_enabled', false);

        $this->getJson('/api/v1/notifications/export?format=csv')
            ->assertOk()
            ->assertJsonPath('data.selected_format', 'csv')
            ->assertJsonPath('data.production_file_generation', false);

        $this->assertDatabaseHas('notification_preferences', [
            'user_id' => $user->id,
            'email_enabled' => false,
            'whatsapp_enabled' => false,
        ]);
    }

    public function test_super_admin_can_view_registry_and_templates_but_regular_user_cannot(): void
    {
        $this->authenticateAs('viewer');

        $this->getJson('/api/v1/notifications/registry')
            ->assertForbidden();

        $this->authenticateAs('super-admin');

        $this->getJson('/api/v1/notifications/registry')
            ->assertOk()
            ->assertJsonPath('data.definition_count', 2);

        $this->getJson('/api/v1/notifications/templates')
            ->assertOk();
    }

    public function test_retry_only_accepts_failed_notification(): void
    {
        $user = $this->authenticateAs('farm-manager');
        $failed = $this->notificationForUser($user, ['status' => 'failed']);
        $delivered = $this->notificationForUser($user, ['status' => 'delivered']);

        $this->postJson('/api/v1/notifications/'.$failed->uuid.'/retry')
            ->assertOk()
            ->assertJsonPath('data.status', 'retry');

        $this->postJson('/api/v1/notifications/'.$delivered->uuid.'/retry')
            ->assertUnprocessable();
    }

    public function test_unauthenticated_user_cannot_access_notification_api(): void
    {
        $this->getJson('/api/v1/notifications')
            ->assertUnauthorized();
    }

    private function authenticateAs(string $roleSlug): User
    {
        $user = $this->createUserWithRole($roleSlug);
        Sanctum::actingAs($user);

        return $user;
    }

    private function createUserWithRole(string $roleSlug): User
    {
        $user = User::query()->create([
            'name' => str($roleSlug)->headline()->toString(),
            'email' => Str::uuid().'@notifications.test',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        $role = Role::query()->firstOrCreate(
            ['slug' => $roleSlug],
            ['name' => str($roleSlug)->headline()->toString()]
        );

        $user->roles()->syncWithoutDetaching([$role->id]);

        return $user;
    }

    private function notificationForUser(User $user, array $overrides = []): NotificationRecord
    {
        return $this->notification([
            'recipient_type' => 'user',
            'recipient_id' => (string) $user->id,
            ...$overrides,
        ]);
    }

    private function notificationForRole(string $roleSlug, array $overrides = []): NotificationRecord
    {
        return $this->notification([
            'recipient_type' => 'role',
            'recipient_id' => $roleSlug,
            ...$overrides,
        ]);
    }

    private function notification(array $overrides = []): NotificationRecord
    {
        $record = NotificationRecord::query()->create([
            'event_name' => 'inventory.low_stock_detected',
            'source_module' => 'Warehouse',
            'correlation_id' => (string) Str::uuid(),
            'notification_type' => 'low_stock_alert',
            'category' => 'inventory',
            'priority' => 'critical',
            'channel' => 'in_app',
            'recipient_type' => 'role',
            'recipient_id' => 'warehouse-staff',
            'title' => 'Low stock detected',
            'message' => 'Inventory stock is below safety level.',
            'status' => 'delivered',
            'attempts' => 1,
            'max_attempts' => 3,
            'metadata' => ['foundation' => true],
            'delivered_at' => now(),
            ...$overrides,
        ]);

        $record->histories()->create([
            'event_name' => $record->event_name,
            'channel' => $record->channel,
            'recipient_type' => $record->recipient_type,
            'recipient_id' => $record->recipient_id,
            'status' => $record->status,
            'attempt' => 1,
            'metadata' => ['seeded_by_test' => true],
        ]);

        return $record;
    }
}

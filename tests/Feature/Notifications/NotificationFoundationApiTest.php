<?php

namespace Tests\Feature\Notifications;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Modules\Roles\Models\Role;
use Modules\Users\Models\User;
use Tests\TestCase;

final class NotificationFoundationApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_authorized_user_can_access_notification_foundation_overview(): void
    {
        $this->authenticateAs('farm-manager');

        $this->getJson('/api/v1/notifications/overview')
            ->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.module.key', 'notification')
            ->assertJsonPath('data.module.event_driven_ready', true)
            ->assertJsonPath('data.module.read_only_business_module', true)
            ->assertJsonPath('data.mvp_channel.key', 'in_app')
            ->assertJsonPath('data.mvp_channel.delivery_enabled', false)
            ->assertJsonPath('data.queue.enabled', true)
            ->assertJsonPath('data.queue.mode', 'asynchronous_ready')
            ->assertJsonPath('data.cache.stores_business_transactions', false)
            ->assertJsonPath('data.engine_health.retention.automatic_cleanup_enabled', false)
            ->assertJsonPath('data.registry.definition_count', 2)
            ->assertJsonPath('data.architecture.queue_worker', 'foundation_ready')
            ->assertJsonPath('meta.delivery_engine_enabled', true)
            ->assertJsonPath('meta.external_channel_delivery_enabled', false)
            ->assertJsonStructure([
                'data' => [
                    'categories',
                    'priorities',
                    'statuses',
                    'channels',
                    'registry',
                    'queue',
                    'notification_center' => [
                        'summary',
                        'features',
                    ],
                    'business_rules',
                ],
            ]);
    }

    public function test_unauthenticated_user_cannot_access_notification_foundation(): void
    {
        $this->getJson('/api/v1/notifications/overview')
            ->assertUnauthorized();
    }

    private function authenticateAs(string $roleSlug): void
    {
        $user = User::query()->create([
            'name' => 'Notification Tester',
            'email' => $roleSlug.'@notifications.test',
            'password' => Hash::make('password'),
            'is_active' => true,
        ]);

        $role = Role::query()->create([
            'name' => str($roleSlug)->headline()->toString(),
            'slug' => $roleSlug,
        ]);

        $user->roles()->syncWithoutDetaching([$role->id]);

        Sanctum::actingAs($user);
    }
}

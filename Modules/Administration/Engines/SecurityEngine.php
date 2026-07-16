<?php

namespace Modules\Administration\Engines;

use Illuminate\Support\Facades\Cache;
use Modules\Administration\Services\ConfigurationCache;
use Modules\Users\Models\User;

final class SecurityEngine
{
    public function __construct(private readonly ConfigurationCache $cache)
    {
    }

    /** @return array<int, string> */
    public function roles(User $user): array
    {
        return Cache::remember($this->cache->userKey('roles', (string) $user->getKey()), $this->cache->ttl(), fn (): array => $user->roles()->pluck('slug')->all());
    }

    public function hasPermission(User $user, string $permission): bool
    {
        return Cache::remember($this->cache->userKey('permission:'.sha1($permission), (string) $user->getKey()), $this->cache->ttl(), fn (): bool => $user->hasPermission($permission));
    }

    /** @return array<string, mixed> */
    public function metadata(): array
    {
        return ['authentication' => 'sanctum', 'authorization' => 'existing_rbac_policy_and_gate', 'permission_evaluation' => 'user_scoped_cache', 'role_resolution' => 'user_scoped_cache', 'least_privilege' => true, 'future_mfa_enabled' => false, 'health' => 'ready'];
    }
}

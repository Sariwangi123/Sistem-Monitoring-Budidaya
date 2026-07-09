<?php

namespace Modules\Auth\Services;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Infrastructure\Logging\AuditLogger;
use Modules\Users\Models\User;

final class AuthService
{
    public function __construct(private readonly AuditLogger $auditLogger)
    {
    }

    public function login(array $credentials): array
    {
        $user = User::query()->where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (! $user->is_active) {
            throw new AuthenticationException('User account is inactive.');
        }

        $token = $user->createToken($credentials['device_name'] ?? 'api')->plainTextToken;
        $this->auditLogger->record('auth.login', ['target_id' => $user->getKey()]);

        return [
            'user' => $user,
            'token' => $token,
            'token_type' => 'Bearer',
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()?->delete();
        $this->auditLogger->record('auth.logout', ['target_id' => $user->getKey()]);
    }

    public function refresh(User $user, string $deviceName = 'api'): array
    {
        $user->currentAccessToken()?->delete();
        $token = $user->createToken($deviceName)->plainTextToken;

        return [
            'token' => $token,
            'token_type' => 'Bearer',
        ];
    }

    public function forgotPassword(string $email): string
    {
        return Password::sendResetLink(['email' => $email]);
    }

    public function resetPassword(array $payload): string
    {
        return Password::reset($payload, function (User $user, string $password): void {
            $user->forceFill(['password' => Hash::make($password)])->save();
        });
    }

    public function changePassword(User $user, string $password): void
    {
        $user->forceFill(['password' => Hash::make($password)])->save();
        $this->auditLogger->record('auth.password_changed', ['target_id' => $user->getKey()]);
    }
}

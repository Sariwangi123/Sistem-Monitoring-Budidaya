<?php

namespace Modules\Auth\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Auth\Requests\ChangePasswordRequest;
use Modules\Auth\Requests\ForgotPasswordRequest;
use Modules\Auth\Requests\LoginRequest;
use Modules\Auth\Requests\ResetPasswordRequest;
use Modules\Auth\Services\AuthService;
use Shared\Http\ApiResponse;

final class AuthController
{
    public function __construct(private readonly AuthService $auth)
    {
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return ApiResponse::success('Login successful.', $this->auth->login($request->validated()));
    }

    public function logout(Request $request): JsonResponse
    {
        $this->auth->logout($request->user());

        return ApiResponse::success('Logout successful.');
    }

    public function refresh(Request $request): JsonResponse
    {
        return ApiResponse::success('Token refreshed.', $this->auth->refresh($request->user()));
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $this->auth->forgotPassword($request->validated('email'));

        return ApiResponse::success('Password reset link sent.');
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $this->auth->resetPassword($request->validated());

        return ApiResponse::success('Password reset successful.');
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $this->auth->changePassword($request->user(), $request->validated('password'));

        return ApiResponse::success('Password changed successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __construct(protected AuthServiceInterface $authService) {}

    public function requestLogin(LoginRequest $request): JsonResponse
    {
        $validated = $request->validated();

        return $this->authService->requestLogin($validated['email'], $validated['password'])->toJsonResponse();
    }
}

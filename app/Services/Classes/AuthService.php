<?php

namespace App\Services\Classes;

use App\Repositories\Interfaces\AuthRepoInterface;
use App\Responses\ApiResponse;
use App\Services\Interfaces\AuthServiceInterface;
use Throwable;

class AuthService implements AuthServiceInterface
{
    public function __construct(protected AuthRepoInterface $authRepository) {}

    public function requestLogin(string $email, string $pass): ApiResponse
    {
        try {
            $result = $this->authRepository->checkInfo($email, $pass);
            if (empty($result)) {
                return ApiResponse::error(__('auth.invalid_credentials'));
            }
            return ApiResponse::success($result,  __('auth.login_success'));
        } catch (Throwable $e) {
            return ApiResponse::error(__('auth.login_error'));
        }
    }
}

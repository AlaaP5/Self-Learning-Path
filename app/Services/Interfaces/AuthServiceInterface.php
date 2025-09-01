<?php

namespace App\Services\Interfaces;

use App\Responses\ApiResponse;

interface AuthServiceInterface
{
    public function requestLogin(string $email, string $pass): ApiResponse;
}

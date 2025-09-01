<?php

namespace App\Repositories\Classes;

use App\DTOs\LoginDto;
use App\Models\User;
use App\Repositories\Interfaces\AuthRepoInterface;
use Illuminate\Support\Facades\Auth;

class AuthRepo implements AuthRepoInterface
{
    public function __construct(protected User $userModel) {}

    public function checkInfo(string $email, string $password): LoginDto| null
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->plainTextToken;
            return new LoginDto($user, $token);
        }
        return null;
    }
}

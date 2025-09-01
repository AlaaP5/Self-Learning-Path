<?php


namespace App\Repositories\Interfaces;

use App\DTOs\LoginDto;

interface AuthRepoInterface
{
    public function checkInfo(string $email, string $pass): LoginDto| null;
}

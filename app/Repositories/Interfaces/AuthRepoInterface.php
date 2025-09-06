<?php


namespace App\Repositories\Interfaces;

use App\DTOs\LoginDto;
use App\Models\User;

interface AuthRepoInterface
{
    public function checkInfo(string $email, string $pass): LoginDto| null;
    public function findStudent(int $studentId): User;
}

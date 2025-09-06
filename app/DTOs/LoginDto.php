<?php

namespace App\DTOs;

use App\Models\User;

class LoginDto
{
    public int $id;
    public string $name;
    public string $email;
    public int $gradeId;
    public string $token;

    public function __construct(?User $user, string $token)
    {
        $this->id = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->gradeId = $user->grade_id;
        $this->token = $token;
    }
}

<?php

namespace App\Services\Interfaces;


interface ExpertSystemServiceInterface
{
    public function getRequires(int $examId, int $studentId): void;
}

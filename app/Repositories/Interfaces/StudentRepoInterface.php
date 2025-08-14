<?php

namespace App\Repositories\Interfaces;

interface StudentRepoInterface
{
    public function getWeakConcepts(int $studentId, ?int $examId = null): array;
    public function saveAnswers(int $studentId, int $examId, array $answers): bool;
}

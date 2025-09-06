<?php

namespace App\Repositories\Interfaces;

interface StudentAnswerRepoInterface
{
    public function saveAnswer(array $data);
    public function calculateMark(int $examId, int $studentId): float;
}

<?php

namespace App\Services\Interfaces;

use App\Responses\ApiResponse;

interface ExamServiceInterface
{
    public function submitExam(int $studentId, int $examId, array $answers): ApiResponse;
      public function getQuestion(int $studentId): ApiResponse;
}

<?php

namespace App\Services\Interfaces;

use App\Responses\ApiResponse;

interface StudentAnalysisServiceInterface
{
    public function analyzeStudent(int $studentId, ?int $examId = null): ApiResponse;
}

<?php

namespace App\Services\Interfaces;

use App\Responses\ApiResponse;

interface SubjectServiceInterface
{
    public function getSubjects(int $gradeId): ApiResponse;
}

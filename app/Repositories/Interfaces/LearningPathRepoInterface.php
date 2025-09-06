<?php

namespace App\Repositories\Interfaces;

use App\DTOs\LearningPathDto;
use App\Models\LearningPath;

interface LearningPathRepoInterface
{
    function addPaths(LearningPathDto $dto): LearningPath;
    function getPaths(int $examId, int $studentId, int $isCompleted);
    function updateStatus(int $examId, int $studentId);
}

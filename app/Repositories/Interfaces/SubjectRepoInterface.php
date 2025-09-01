<?php

namespace App\Repositories\Interfaces;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Collection;

interface SubjectRepoInterface
{
    function findSubject(string $name, int $gradeId, string $semester): ?Subject;
    function findSubjectByGrade(int $gradeId): ?Collection;
}

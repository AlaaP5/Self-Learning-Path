<?php

namespace App\Repositories\Interfaces;

use App\Models\Subject;

interface SubjectRepoInterface
{
    function findSubject(string $name, int $grade_id, string $semester): ?Subject;
}

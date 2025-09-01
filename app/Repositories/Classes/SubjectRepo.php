<?php

namespace App\Repositories\Classes;

use App\Models\Subject;
use App\Repositories\Interfaces\SubjectRepoInterface;


class SubjectRepo implements SubjectRepoInterface
{
    public function __construct(protected Subject $subjectModel) {}

    function findSubject(string $name, int $grade_id, string $semester): ?Subject
    {
        return $this->subjectModel->where('name', $name)
            ->where('grade_id', $grade_id)
            ->where('semester', $semester)
            ->first();
    }
}

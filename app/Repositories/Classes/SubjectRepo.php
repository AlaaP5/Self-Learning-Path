<?php

namespace App\Repositories\Classes;

use App\Models\Subject;
use App\Repositories\Interfaces\SubjectRepoInterface;
use Illuminate\Database\Eloquent\Collection;

class SubjectRepo implements SubjectRepoInterface
{
    public function __construct(protected Subject $subjectModel) {}

    function findSubject(string $name, int $gradeId, string $semester): ?Subject
    {
        return $this->subjectModel->where('name', $name)
            ->where('grade_id', $gradeId)
            ->where('semester', $semester)
            ->first();
    }

    function findSubjectByGrade(int $gradeId): ?Collection
    {
        return $this->subjectModel->where('grade_id', $gradeId)
        ->get();
    }
}

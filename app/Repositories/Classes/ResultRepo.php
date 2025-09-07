<?php

namespace App\Repositories\Classes;

use App\DTOs\ResultDto;
use App\Models\Result;
use App\Repositories\Interfaces\ResultRepoInterface;
use Illuminate\Database\Eloquent\Collection;

class ResultRepo implements ResultRepoInterface
{
    public function __construct(protected Result $resultModel) {}


    public function addResult(ResultDto $dto): Result
    {
        return $this->resultModel->create($dto->toArray());
    }

    public function getResults(int $studentId): Collection
    {
        return $this->resultModel->where('student_id', $studentId)
            ->join('exams', 'results.exam_id', '=', 'exams.id')
            ->join('subjects', 'exams.subject_id', '=', 'subjects.id')
            ->select(
                'results.message as message',
                'results.mark as mark',
                'subjects.name as subjectName'
            )
            ->get();
    }
}

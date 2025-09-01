<?php

namespace App\Repositories\Classes;

use App\Models\Exam;
use App\Repositories\Interfaces\ExamRepoInterface;


class ExamRepo implements ExamRepoInterface
{
    public function __construct(protected Exam $examModel) {}

    public function findActiveExam(int $examId): Exam
    {
        return $this->examModel->where('id', $examId)
            ->where('is_active', true)
            ->first();
    }
}

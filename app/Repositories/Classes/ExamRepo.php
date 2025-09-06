<?php

namespace App\Repositories\Classes;

use App\Models\Exam;
use App\Repositories\Interfaces\ExamRepoInterface;
use Illuminate\Support\Facades\Auth;

class ExamRepo implements ExamRepoInterface
{
    public function __construct(protected Exam $examModel) {}

    public function findActiveExam(int $examId): Exam
    {
        return $this->examModel->where('id', $examId)
            ->where('is_active', true)
            ->first();
    }

    public function getQuesOfExam(int $examId)
    {
        $exam = $this->examModel->where('id', $examId)->first();
        return $questions = $exam?->questions;
    }

    public function getExams()
    {
        $gradeId = Auth::user()->grade_id;

        return $this->examModel
            ->join('subjects', 'exams.subject_id', '=', 'subjects.id')
            ->where('subjects.grade_id', $gradeId)
            ->select('exams.*', 'subjects.name as subject_name')
            ->get();
    }

    public function updateStatus(int $examId): void
    {
        $this->examModel->where('id', $examId)
            ->update([
                'is_active' => false
            ]);
    }

    public function findExam(int $examId): Exam
    {
        return $this->examModel->where('id', $examId)->first();
    }
}

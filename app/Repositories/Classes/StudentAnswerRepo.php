<?php

namespace App\Repositories\Classes;

use App\Models\StudentAnswer;
use App\Repositories\Interfaces\StudentAnswerRepoInterface;

class StudentAnswerRepo implements StudentAnswerRepoInterface
{

    public function __construct(protected StudentAnswer $studentAnswerModel) {}

    public function saveAnswer(array $data)
    {
        return $this->studentAnswerModel->insert($data);
    }

    public function calculateMark(int $examId, int $studentId): float
    {
        $totalQuestions = $this->studentAnswerModel
            ->where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->count();

        $correctAnswers = $this->studentAnswerModel
            ->where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->where('is_correct', 1)
            ->count();

        return ($correctAnswers / $totalQuestions) * 100;
    }
}

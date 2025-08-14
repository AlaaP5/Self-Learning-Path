<?php

// app/Repositories/Classes/StudentRepo.php
namespace App\Repositories\Classes;

use App\Models\Question;
use App\Repositories\Interfaces\StudentRepoInterface;
use App\Models\StudentAnswer;
use Illuminate\Support\Facades\DB;


class StudentRepo implements StudentRepoInterface
{
    public function __construct(protected StudentAnswer $studentAnswerModel, protected Question $questionModel) {}


    public function getWeakConcepts(int $studentId, $examId): array
    {
        $query = $this->studentAnswerModel->query()
            ->select([
                'concepts.id',
                'concepts.name',
                DB::raw('COUNT(*) as total_questions'),
                DB::raw('SUM(CASE WHEN student_answers.is_correct = 0 THEN 1 ELSE 0 END) as wrong_answers'),
                DB::raw('(SUM(CASE WHEN student_answers.is_correct = 0 THEN 1 ELSE 0 END) / COUNT(*)) * 100 as error_rate')
            ])
            ->join('questions', 'student_answers.question_id', '=', 'questions.id')
            ->join('concepts', 'questions.concept_id', '=', 'concepts.id')
            ->where('student_answers.student_id', $studentId)
            ->groupBy('concepts.id', 'concepts.name');

        $query->where('student_answers.exam_id', $examId);

        return $query->having('wrong_answers', '>=', 2)
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'error_rate' => (float)$item->error_rate,
                    'total_questions' => $item->total_questions,
                    'wrong_answers' => $item->wrong_answers
                ];
            })
            ->toArray();
    }

    public function saveAnswers(int $studentId, int $examId, array $answers): bool
    {
        $questionIds = collect($answers)->pluck('question_id');
        $questions = $this->questionModel->whereIn('id', $questionIds)
            ->get()
            ->keyBy('id');

        $answersToSave = collect($answers)->map(function($answer) use ($studentId, $examId, $questions) {
            $question = $questions[$answer['question_id']] ?? null;

            return [
                'student_id' => $studentId,
                'exam_id' => $examId,
                'question_id' => $answer['question_id'],
                'selected_option' => $answer['selected_option'],
                'is_correct' => $question ? $answer['selected_option'] === $question->correct_option : false,
                'created_at' => now(),
                'updated_at' => now()
            ];
        });

        return $this->studentAnswerModel->insert($answersToSave->toArray());
    }
}

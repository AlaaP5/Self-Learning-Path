<?php

namespace App\Services\Classes;

use App\Jobs\AnalyzeAnswersJob;
use App\Models\Question;
use App\Repositories\Interfaces\ExamRepoInterface;
use App\Repositories\Interfaces\StudentAnswerRepoInterface;
use App\Responses\ApiResponse;
use App\Services\Interfaces\ExpertSystemServiceInterface;
use App\Services\Interfaces\StudentAnswerServiceInterface;
use Exception;
use Illuminate\Support\Facades\Auth;

class StudentAnswerService implements StudentAnswerServiceInterface
{
    public function __construct(protected StudentAnswerRepoInterface $studentAnswerRepo, protected ExamRepoInterface $examRepo, protected ExpertSystemServiceInterface $expertSystemService) {}

    public function storeAnswers(array $data): ApiResponse
    {

        try {

            $studentId = Auth::id();
            $examId = $data['exam_id'];

            $insertData = [];

            foreach ($data['answers'] as $answer) {
                $correctOption = Question::where('id', $answer['question_id'])->value('correct_option');
                $isCorrect = $correctOption === $answer['selected_option'];


                $insertData[] = [
                    'student_id' => $studentId,
                    'exam_id' => $examId,
                    'question_id' => $answer['question_id'],
                    'selected_option' => $answer['selected_option'],
                    'is_correct' => $isCorrect,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            $this->examRepo->updateStatus($examId);

            $this->studentAnswerRepo->saveAnswer($insertData);

            dispatch(new AnalyzeAnswersJob($this->expertSystemService, $examId, $studentId));

            return ApiResponse::success(null, __('shared.success'));
        } catch (Exception $e) {
            return ApiResponse::error(__('shared.general_error'));
        }
    }
}

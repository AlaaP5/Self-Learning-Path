<?php

namespace App\Services\Classes;

use App\Repositories\Interfaces\ExamRepoInterface;
use App\Repositories\Interfaces\StudentRepoInterface;
use App\Responses\ApiResponse;
use App\Services\Interfaces\ExamServiceInterface;


class ExamService implements ExamServiceInterface
{
    public function __construct(protected ExamRepoInterface $examRepo, protected StudentRepoInterface $studentRepo) {}

    public function submitExam(int $studentId, int $examId, array $answers): ApiResponse
    {
        $exam = $this->examRepo->findActiveExam($examId);

        if(empty($exam)) {
            return ApiResponse::error(__('shared.general_error'));
        }

        $savedAnswers = $this->studentRepo->saveAnswers($studentId, $examId, $answers);

        return ApiResponse::success($savedAnswers, __('shared.success'));
    }
}

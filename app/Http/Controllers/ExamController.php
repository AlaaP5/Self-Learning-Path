<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitExamRequest;
use App\Services\Interfaces\ExamServiceInterface;
use Illuminate\Http\JsonResponse;

class ExamController extends Controller
{
    public function __construct(protected ExamServiceInterface $examService) {}

    public function submitExam(SubmitExamRequest $request): JsonResponse
    {
        $validated = $request->validated();

        return $this->examService->submitExam($validated['student_id'], $validated['exam_id'], $validated['answers'])->toJsonResponse();
    }
}

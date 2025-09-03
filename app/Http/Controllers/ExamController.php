<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubmitExamRequest;
use App\Services\Interfaces\ExamServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function __construct(protected ExamServiceInterface $examService) {}

    public function submitExam(SubmitExamRequest $request): JsonResponse
    {
        $validated = $request->validated();

        return $this->examService->submitExam($validated['student_id'], $validated['exam_id'], $validated['answers'])->toJsonResponse();
    }

     public function getQuesOfExam(Request $request): JsonResponse
    {
        return $this->examService->getQuestion($request['subject_id'],$request['id'])->toJsonResponse();
    }
}

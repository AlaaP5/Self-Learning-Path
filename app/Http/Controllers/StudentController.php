<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnalyzeStudentRequest;
use App\Services\Interfaces\StudentAnalysisServiceInterface;


class StudentController extends Controller
{
    public function __construct(protected StudentAnalysisServiceInterface $analysisService) {}

    public function analyzeStudent(AnalyzeStudentRequest $request)
    {
        $validated = $request->validated();

        return $this->analysisService->analyzeStudent($validated['student_id'], $validated['exam_id'])->toJsonResponse();
    }
}

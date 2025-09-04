<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentAnswersRequest;
use App\Services\Interfaces\StudentAnswerServiceInterface;
use Illuminate\Http\JsonResponse;

class StudentAnswerController extends Controller
{
    public function __construct(protected StudentAnswerServiceInterface $studentAnswerService) {}

    public function store(StoreStudentAnswersRequest $request): JsonResponse
    {
        return $this->studentAnswerService
            ->storeAnswers($request->validated())
            ->toJsonResponse();
    }
}

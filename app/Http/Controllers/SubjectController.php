<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\SubjectServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function __construct(protected SubjectServiceInterface $subjectService) {}

    public function getSubjects(Request $request): JsonResponse
    {
        return $this->subjectService->getSubjects($request['grade_id'])->toJsonResponse();
    }
}

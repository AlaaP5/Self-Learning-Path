<?php

namespace App\Services\Classes;

use App\Repositories\Interfaces\SubjectRepoInterface;
use App\Responses\ApiResponse;
use App\Services\Interfaces\SubjectServiceInterface;
use Exception;

class SubjectService implements SubjectServiceInterface
{
    public function __construct(protected SubjectRepoInterface $subjectRepo) {}

    public function getSubjects(int $gradeId): ApiResponse
    {
        try {
            $subjects = $this->subjectRepo->findSubjectByGrade($gradeId);

            return ApiResponse::success($subjects, __('shared.success'));
        } catch(Exception $e) {
            return ApiResponse::error(__('shared.general_error'));
        }
    }
}

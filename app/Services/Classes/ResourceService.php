<?php

namespace App\Services\Classes;

use App\Repositories\Interfaces\ResourceRepoInterface;
use App\Responses\ApiResponse;
use App\Services\Interfaces\ResourceServiceInterface;
use Exception;

class ResourceService implements ResourceServiceInterface
{
    public function __construct(protected ResourceRepoInterface $resourceRepo) {}

    public function getResources(int $subjectId): ApiResponse
    {
        
        try {
            $resources = $this->resourceRepo->findResourceBySubject($subjectId);

            return ApiResponse::success($resources, __('shared.success'));
        } catch(Exception $e) {
            return ApiResponse::error(__('shared.general_error'));
        }
    }
}

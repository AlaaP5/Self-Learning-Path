<?php

namespace App\Services\Interfaces;

use App\Responses\ApiResponse;

interface ResourceServiceInterface
{
    public function getResources(int $subjectId): ApiResponse;
}

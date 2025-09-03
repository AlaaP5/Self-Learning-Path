<?php

namespace App\Http\Controllers;

use App\Services\Interfaces\ResourceServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function __construct(protected ResourceServiceInterface $resourceService) {}

    public function getResources(Request $request): JsonResponse
    {
        return $this->resourceService->getResources($request['subject_id'])->toJsonResponse();
    }
}

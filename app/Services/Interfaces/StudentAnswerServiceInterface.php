<?php

namespace App\Services\Interfaces;

use App\Responses\ApiResponse;

interface StudentAnswerServiceInterface
{
    public function storeAnswers(array $data): ApiResponse;
}

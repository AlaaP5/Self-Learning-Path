<?php

namespace App\Repositories\Interfaces;

use App\DTOs\ResultDto;
use App\Models\Result;
use Illuminate\Database\Eloquent\Collection;

interface ResultRepoInterface
{
    function addResult(ResultDto $dto): Result;
    function getResults(int $studentId): Collection;
}

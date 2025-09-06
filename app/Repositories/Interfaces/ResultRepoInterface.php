<?php

namespace App\Repositories\Interfaces;

use App\DTOs\ResultDto;
use App\Models\Result;

interface ResultRepoInterface
{
    function addResult(ResultDto $dto): Result;
}

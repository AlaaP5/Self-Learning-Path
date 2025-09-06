<?php

namespace App\Repositories\Classes;

use App\DTOs\ResultDto;
use App\Models\Result;
use App\Repositories\Interfaces\ResultRepoInterface;


class ResultRepo implements ResultRepoInterface
{
    public function __construct(protected Result $resultModel) {}


    public function addResult(ResultDto $dto): Result
    {
        return $this->resultModel->create($dto->toArray());
    }
}

<?php

namespace App\Repositories\Classes;

use App\Models\Grade;
use App\Repositories\Interfaces\GradeRepoInterface;


class GradeRepo implements GradeRepoInterface
{
    public function __construct(protected Grade $gradeModel) {}

    function findByName(string $name): Grade
    {
        return $this->gradeModel->where('name', $name)->first();
    }
}

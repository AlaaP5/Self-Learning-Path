<?php

namespace App\Repositories\Classes;

use App\Models\StudentAnswer;
use App\Repositories\Interfaces\StudentAnswerRepoInterface;

class StudentAnswerRepo implements StudentAnswerRepoInterface
{
    public function saveAnswer(array $data)
    {
        return StudentAnswer::insert($data); 
    }
}

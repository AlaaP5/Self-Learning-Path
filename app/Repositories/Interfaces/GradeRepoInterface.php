<?php

namespace App\Repositories\Interfaces;

use App\Models\Grade;

interface GradeRepoInterface
{
    function findByName(string $name): Grade;
}

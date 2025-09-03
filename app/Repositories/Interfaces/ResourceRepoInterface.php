<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface ResourceRepoInterface
{
    function findResourceBySubject(int $subjectId): ?Collection;
}

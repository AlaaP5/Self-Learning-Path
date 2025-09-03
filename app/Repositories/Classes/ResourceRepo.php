<?php

namespace App\Repositories\Classes;

use App\Models\Resource;
use App\Models\Subject;
use App\Repositories\Interfaces\ResourceRepoInterface;
use Illuminate\Database\Eloquent\Collection;

class ResourceRepo implements ResourceRepoInterface
{
    public function __construct(protected Resource $resourceModel) {}
    function findResourceBySubject(int $subjectId): ?Collection
    {
        
    
        return $this->resourceModel->where('subject_id', $subjectId)
        ->get();
    }
}

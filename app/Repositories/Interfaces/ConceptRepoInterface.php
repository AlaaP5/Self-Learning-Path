<?php

namespace App\Repositories\Interfaces;

use App\Models\Concept;
use Illuminate\Database\Eloquent\Collection;

interface ConceptRepoInterface
{
    function findByName(string $name): Concept;
    function getAll(): Collection;
    function getPrerequisitesForConcepts(array $conceptIds): array;
    function getConceptsWithResources(array $conceptIds);
}

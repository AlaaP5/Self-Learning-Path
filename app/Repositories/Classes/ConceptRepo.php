<?php

namespace App\Repositories\Classes;

use App\Models\Concept;
use App\Models\ConceptPrerequisite;
use App\Repositories\Interfaces\ConceptRepoInterface;
use Illuminate\Database\Eloquent\Collection;

class ConceptRepo implements ConceptRepoInterface
{
    public function __construct(protected Concept $conceptModel, protected ConceptPrerequisite $conceptPrerequisiteModel) {}

    function findByName(string $name): ?Concept
    {
        return $this->conceptModel->where('name', $name)->first();
    }

    function getAll(): Collection
    {
        return $this->conceptModel->all();
    }

    public function getPrerequisitesForConcepts(array $conceptIds): array
    {
        return $this->conceptPrerequisiteModel->whereIn('concept_id', $conceptIds)
            ->get()
            ->map(function ($item) {
                return [
                    'concept_id' => $item->concept_id,
                    'requires' => $item->prerequisite_concept_id
                ];
            })
            ->toArray();
    }

    public function getConceptsWithResources(array $conceptIds)
    {
        return $this->conceptModel->whereIn('id', $conceptIds)
            ->with('resources')
            ->get()
            ->keyBy('id');
    }
}

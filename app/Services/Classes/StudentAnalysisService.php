<?php


// app/Services/Classes/StudentAnalysisService.php
namespace App\Services\Classes;

use App\Repositories\Interfaces\StudentRepoInterface;
use App\Repositories\Interfaces\ConceptRepoInterface;
use App\Responses\ApiResponse;
use App\Services\Interfaces\ExpertSystemServiceInterface;
use App\Services\Interfaces\StudentAnalysisServiceInterface;

class StudentAnalysisService implements StudentAnalysisServiceInterface
{
    public function __construct(
        protected StudentRepoInterface $studentRepo,
        protected ConceptRepoInterface $conceptRepo,
        protected ExpertSystemServiceInterface $expertSystem
    ) {}

    public function analyzeStudent(int $studentId, ?int $examId = null): ApiResponse
    {
        $weakConcepts = $this->studentRepo->getWeakConcepts($studentId, $examId);

        $prerequisites = $this->conceptRepo->getPrerequisitesForConcepts(
            collect($weakConcepts)->pluck('id')->toArray()
        );

        $learningPaths = $this->expertSystem->analyze($weakConcepts, $prerequisites);

        $allConceptIds = collect($learningPaths)->pluck('concept_id')->unique()->toArray();
        $concepts = $this->conceptRepo->getConceptsWithResources($allConceptIds);

        $groupedPaths = collect($learningPaths)->groupBy('path_id');

        $mappedPaths = $groupedPaths->map(function ($pathGroup) use ($concepts) {
            return [
                'path_id' => $pathGroup->first()['path_id'],
                'concepts' => $this->mapLearningPath($pathGroup->toArray(), $concepts)
            ];
        });

        return ApiResponse::success([
            'weak_concepts' => $weakConcepts,
            'learning_paths' => $mappedPaths->values()->toArray()
        ], __('shared.success'));
    }

    protected function mapLearningPath(array $learningPaths, $concepts): array
    {
        return collect($learningPaths)->map(function ($item) use ($concepts) {
            $concept = $concepts[$item['concept_id']];
            return [
                'concept_id' => $item['concept_id'],
                'concept_name' => $concept->name,
                'priority' => $item['priority'],
                'resources' => $concept->resources,
                'is_prerequisite' => $item['priority'] === 1
            ];
        })->toArray();
    }
}

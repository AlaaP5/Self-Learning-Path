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

        $learningPath = $this->expertSystem->analyze($weakConcepts, $prerequisites);

        $concepts = $this->conceptRepo->getConceptsWithResources(
            collect($learningPath)->pluck('concept_id')->toArray()
        );

        return ApiResponse::success([
            'weak_concepts' => $weakConcepts,
            'learning_path' => $this->mapLearningPath($learningPath, $concepts)
        ], __('shared.success'));
    }

    protected function mapLearningPath(array $learningPath, $concepts): array
    {
        return collect($learningPath)->map(function ($item) use ($concepts) {
            $concept = $concepts[$item['concept_id']];
            return [
                'concept_id' => $item['concept_id'],
                'concept_name' => $concept->name,
                'priority' => $item['priority'],
                'resources' => $concept->resources
            ];
        })->toArray();
    }
}

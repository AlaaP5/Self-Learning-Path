<?php

// app/Services/Classes/ExpertSystemService.php
namespace App\Services\Classes;

use App\Repositories\Interfaces\ConceptRepoInterface;
use App\Repositories\Interfaces\ExamRepoInterface;
use App\Repositories\Interfaces\StudentRepoInterface;
use App\Services\Interfaces\ExpertSystemServiceInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ExpertSystemService implements ExpertSystemServiceInterface
{
    public function __construct(protected ExamRepoInterface $examRepo, protected StudentRepoInterface $studentRepo, protected ConceptRepoInterface $conceptRepo) {}

    private function analyze(array $weakConcepts, array $prerequisites): array
    {
        $process = new Process([
            'python3',
            base_path('Python/expert_system.py'),
            json_encode($weakConcepts),
            json_encode($prerequisites)
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return json_decode($process->getOutput(), true);
    }


    public function getRequires(int $examId, int $studentId): void
    {
        $weakConcepts = $this->studentRepo->getWeakConcepts($studentId, $examId);

        $exam = $this->examRepo->findExam($examId);

        $concepts = $this->conceptRepo->getConceptsBySubjectId($exam->subject_id);

        $prerequisites = $this->conceptRepo->getPrerequisitesForConcepts($concepts);

        $this->analyze($weakConcepts, $prerequisites);
    }

}

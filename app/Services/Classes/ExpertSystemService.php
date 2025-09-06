<?php

namespace App\Services\Classes;

use App\DTOs\LearningPathDto;
use App\DTOs\ResultDto;
use App\Mail\SendLearningPathMail;
use App\Repositories\Interfaces\AuthRepoInterface;
use App\Repositories\Interfaces\ConceptRepoInterface;
use App\Repositories\Interfaces\ExamRepoInterface;
use App\Repositories\Interfaces\LearningPathRepoInterface;
use App\Repositories\Interfaces\ResultRepoInterface;
use App\Repositories\Interfaces\StudentAnswerRepoInterface;
use App\Repositories\Interfaces\StudentRepoInterface;
use App\Services\Interfaces\ExpertSystemServiceInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ExpertSystemService implements ExpertSystemServiceInterface
{
    public function __construct(
        protected LearningPathRepoInterface $learningPathRepo,
        protected ExamRepoInterface $examRepo,
        protected StudentRepoInterface $studentRepo,
        protected ConceptRepoInterface $conceptRepo,
        protected AuthRepoInterface $authRepo,
        protected ResultRepoInterface $resultRepo,
        protected StudentAnswerRepoInterface $studentAnswerRepo
    ) {}


    private function analyze(array $weakConcepts, array $prerequisites): array
    {
        if (empty($weakConcepts)) {
            return [];
        }

        $process = new Process([
            'python',
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


    private function buildMessageFromPaths(Collection $paths): string
    {
        $studentName = $paths->first()->first()['studentName'];

        $message = "صديقي {$studentName} 🌟\n";
        $message .= "لقد لاحظنا وجود بعض المفاهيم التي تحتاج إلى مراجعة حتى تتجاوز نقاط الضعف وتحقق أداء أفضل.\n";
        $message .= "ننصحك بالتركيز على التالي:\n\n";

        $counter = 1;
        foreach ($paths as $items) {
            $message .= $this->formatConceptsText($items, $counter);
            $counter++;
        }

        $message .= "\n💡 ملاحظة: كلما راجعت هذه المفاهيم بالترتيب، ستتمكن من تقوية مستواك بشكل أسرع بإذن الله.";

        return $message;
    }

    private function formatConceptsText(Collection $items, int $counter): string
    {
        $concepts = $items->map(
            fn($item) => "مفهوم {$item['conceptName']} في مادة {$item['subjectName']}"
        )->toArray();

        $conceptsText = implode(' و ', $concepts);

        return "{$counter}️⃣ مراجعة {$conceptsText}.\n";
    }



    public function getRequires(int $examId, int $studentId): void
    {
        $weakConcepts   = $this->studentRepo->getWeakConcepts($studentId, $examId);
        $exam           = $this->examRepo->findExam($examId);
        $concepts       = $this->conceptRepo->getConceptsBySubjectId($exam->subject_id);
        $prerequisites  = $this->conceptRepo->getPrerequisitesForConcepts($concepts);

        $result = $this->analyze($weakConcepts, $prerequisites);

        if (!empty($result)) {
            foreach ($result as $res) {
                $this->learningPathRepo->addPaths(new LearningPathDto($res, $studentId, $examId));
            }
        }

        $paths = $this->learningPathRepo->getPaths($examId, $studentId, 0);

        $message = $this->buildMessageFromPaths($paths);

        $student = $this->authRepo->findStudent($studentId);

        Mail::to($student->email)->send(new SendLearningPathMail($message));

        $this->learningPathRepo->updateStatus($examId, $studentId);

        $mark = $this->studentAnswerRepo->calculateMark($examId, $studentId);

        $this->resultRepo->addResult(new ResultDto($message, $mark, $studentId, $examId));
    }
}

<?php

namespace App\Jobs;

use App\Services\Interfaces\ExpertSystemServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class AnalyzeAnswersJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected ExpertSystemServiceInterface $expertSystemService, protected int $examId, protected int $studentId) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->expertSystemService->getRequires($this->examId, $this->studentId);
    }
}

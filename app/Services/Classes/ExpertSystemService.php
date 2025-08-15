<?php

// app/Services/Classes/ExpertSystemService.php
namespace App\Services\Classes;

use App\Services\Interfaces\ExpertSystemServiceInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ExpertSystemService implements ExpertSystemServiceInterface
{
    public function analyze(array $weakConcepts, array $prerequisites): array
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
}

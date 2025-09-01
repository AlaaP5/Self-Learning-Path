<?php

namespace App\Services\Interfaces;


interface ExpertSystemServiceInterface
{
    public function analyze(array $weakConcepts, array $prerequisites): array;
}

<?php


namespace App\Repositories\Interfaces;

use App\Models\Exam;

interface ExamRepoInterface
{
    public function findActiveExam(int $examId);
    public function getQuesOfExam(int $examId);
    public function getExams();
    public function updateStatus(int $examId): void;
    public function findExam(int $examId): Exam;
}

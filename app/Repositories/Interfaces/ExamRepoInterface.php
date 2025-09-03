<?php


namespace App\Repositories\Interfaces;

interface ExamRepoInterface
{
    public function findActiveExam(int $examId);
    public function getQuesOfExam(int $subjectId);
}

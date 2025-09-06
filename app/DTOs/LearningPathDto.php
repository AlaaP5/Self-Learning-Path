<?php

namespace App\DTOs;


class LearningPathDto
{
    public int $pathId;
    public int $studentId;
    public int $examId;
    public int $conceptId;
    public int $priority;

    public function __construct(?array $path, int $studentId, int $examId)
    {
        $this->pathId = $path['path_id'];
        $this->studentId = $studentId;
        $this->examId = $examId;
        $this->conceptId = $path['concept_id'];
        $this->priority = $path['priority'];
    }

    public function toArray(): array
    {
        return [
            'path_id' => $this->pathId,
            'student_id' => $this->studentId,
            'exam_id' => $this->examId,
            'recommended_order' => $this->priority,
            'is_completed' => 0,
            'concept_id' => $this->conceptId
        ];
    }
}

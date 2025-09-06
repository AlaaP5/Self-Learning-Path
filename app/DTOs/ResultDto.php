<?php

namespace App\DTOs;


class ResultDto
{
    public string $message;
    public float $mark;
    public int $studentId;
    public int $examId;

    public function __construct(string $message, float $mark, int $studentId, int $examId)
    {
        $this->message = $message;
        $this->mark = $mark;
        $this->studentId = $studentId;
        $this->examId = $examId;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->message,
            'mark' => $this->mark,
            'student_id' => $this->studentId,
            'exam_id' => $this->examId
        ];
    }
}

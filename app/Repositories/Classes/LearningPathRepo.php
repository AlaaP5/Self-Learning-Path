<?php

namespace App\Repositories\Classes;

use App\DTOs\LearningPathDto;
use App\Models\LearningPath;
use App\Repositories\Interfaces\LearningPathRepoInterface;
use Illuminate\Database\Eloquent\Collection;

class LearningPathRepo implements LearningPathRepoInterface
{
    public function __construct(protected LearningPath $learningPathModel) {}


    public function addPaths(LearningPathDto $dto): LearningPath
    {
        return $this->learningPathModel->create($dto->toArray());
    }

    public function getPaths(int $examId, int $studentId, int $isCompleted)
    {
        return $this->learningPathModel
            ->join('concepts', 'learning_paths.concept_id', '=', 'concepts.id')
            ->join('subjects', 'concepts.subject_id', '=', 'subjects.id')
            ->join('users', 'learning_paths.student_id', '=', 'users.id')
            ->where('learning_paths.exam_id', $examId)
            ->where('learning_paths.student_id', $studentId)
            ->where('learning_paths.is_completed', $isCompleted)
            ->select(
                'learning_paths.path_id',
                'learning_paths.recommended_order as priority',
                'learning_paths.is_completed as status',
                'users.name as studentName',
                'subjects.name as subjectName',
                'concepts.name as conceptName'
            )
            ->orderBy('learning_paths.path_id')
            ->orderBy('learning_paths.recommended_order')
            ->get()
            ->groupBy('path_id');
    }

    public function updateStatus(int $examId, int $studentId)
    {
        $this->learningPathModel
            ->where('learning_paths.exam_id', $examId)
            ->where('learning_paths.student_id', $studentId)
            ->update([
                'is_completed' => 1
            ]);

    }
}

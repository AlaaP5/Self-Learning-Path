<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Repositories\Interfaces\ConceptRepoInterface;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function __construct(
        protected Question $questionModel,
        protected ConceptRepoInterface $conceptRepo
    ) {}

    public function run(): void
    {
        $concepts = $this->conceptRepo->getAll();

        foreach ($concepts as $concept) {
            $this->createQuestionsForConcept($concept);
        }
    }

    private function createQuestionsForConcept($concept): void
    {
        $questions = [
            [
                'question_text' => "سؤال 1 عن {$concept->name}",
                'option_a' => 'الإجابة أ',
                'option_b' => 'الإجابة ب',
                'option_c' => 'الإجابة ج',
                'option_d' => 'الإجابة د',
                'correct_option' => 'A'
            ],
            [
                'question_text' => "سؤال 2 عن {$concept->name}",
                'option_a' => 'الإجابة أ',
                'option_b' => 'الإجابة ب',
                'option_c' => 'الإجابة ج',
                'option_d' => 'الإجابة د',
                'correct_option' => 'B'
            ],
            [
                'question_text' => "سؤال 3 عن {$concept->name}",
                'option_a' => 'الإجابة أ',
                'option_b' => 'الإجابة ب',
                'option_c' => 'الإجابة ج',
                'option_d' => 'الإجابة د',
                'correct_option' => 'C'
            ]
        ];

        foreach ($questions as $question) {
            $this->questionModel->create(array_merge($question, [
                'concept_id' => $concept->id
            ]));
        }
    }
}

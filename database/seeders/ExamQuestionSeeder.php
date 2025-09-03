<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExamQuestionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('exam_question')->insert([
            [
                'exam_id' => 1,
                'question_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'exam_id' => 1,
                'question_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

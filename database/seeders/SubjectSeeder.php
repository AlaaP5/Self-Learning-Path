<?php

namespace Database\Seeders;

use App\Models\Subject;
use App\Repositories\Interfaces\GradeRepoInterface;
use Illuminate\Database\Seeder;


class SubjectSeeder extends Seeder
{
    public function __construct(protected Subject $subjectModel, protected GradeRepoInterface $gradeRepo) {}
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grade10 = $this->gradeRepo->findByName('first');
        $grade11 = $this->gradeRepo->findByName('second');

        $subjects = [
            [
                'name' => 'الرياضيات',
                'grade_id' => $grade10->id,
                'semester' => 'first'
            ],
            [
                'name' => 'الرياضيات',
                'grade_id' => $grade10->id,
                'semester' => 'second'
            ],
            [
                'name' => 'الرياضيات',
                'grade_id' => $grade11->id,
                'semester' => 'first'
            ],
            [
                'name' => 'الرياضيات',
                'grade_id' => $grade11->id,
                'semester' => 'second'
            ]
        ];

        foreach ($subjects as $subject) {
            $this->subjectModel->create($subject);
        }
    }
}

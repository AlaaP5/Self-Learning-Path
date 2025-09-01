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
    
    $grade10 = $this->gradeRepo->findByName('first');   // العاشر
    $grade11 = $this->gradeRepo->findByName('second');  // الحادي عشر
    $grade12 = $this->gradeRepo->findByName('third');   // الثالث الثانوي

    $grades = [
        $grade10,
        $grade11,
        $grade12,
    ];

    $semesters = ['first', 'second']; // فصول

    
    $subjectNames = [
        'الرياضيات',
        'الفيزياء',
        'الكيمياء',
        'اللغة العربية',
        'اللغة الإنجليزية',
        'العلوم والاحياء',
        'اللغة الفرنسية ',
        'الفلسفة',
        'التاريخ',
        'الجغرافيا',

    ];

    foreach ($subjectNames as $name) {
        foreach ($grades as $grade) {
            foreach ($semesters as $sem) {
                $this->subjectModel->create([
                    'name'      => $name,
                    'grade_id'  => $grade->id,
                    'semester'  => $sem
                ]);
            }
        }
    }
}}


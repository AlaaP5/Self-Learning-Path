<?php

namespace Database\Seeders;

use App\Models\Concept;
use App\Models\ConceptPrerequisite;
use App\Repositories\Interfaces\ConceptRepoInterface;
use App\Repositories\Interfaces\GradeRepoInterface;
use App\Repositories\Interfaces\SubjectRepoInterface;
use Illuminate\Database\Seeder;

class ConceptSeeder extends Seeder
{
    public function __construct(protected Concept $conceptModel, protected ConceptPrerequisite $conceptPrerequisiteModel, protected SubjectRepoInterface $subjectRepo, protected ConceptRepoInterface $conceptRepo, protected GradeRepoInterface $gradeRepo) {}
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grade10 = $this->gradeRepo->findByName('first');
        $grade11 = $this->gradeRepo->findByName('second');

        $subject_1_1 = $this->subjectRepo->findSubject('الرياضيات', $grade10->id, 'first');

        $subject_1_2 = $this->subjectRepo->findSubject('الرياضيات', $grade10->id, 'second');

        $subject_2_1 = $this->subjectRepo->findSubject('الرياضيات', $grade11->id, 'first');

        $subject_2_2 = $this->subjectRepo->findSubject('الرياضيات', $grade11->id, 'second');

        $conceptsData = [
            // first grade

            // first semester
            [
                'name' => 'الهندسة الإقليدية',
                'subject_id' => $subject_1_1->id,
                'prerequisites' => []
            ],
            [
                'name' => 'الإحصاء الوصفي',
                'subject_id' => $subject_1_1->id,
                'prerequisites' => []
            ],
            [
                'name' => 'النسب المثلثية',
                'subject_id' => $subject_1_1->id,
                'prerequisites' => []
            ],
            [
                'name' => 'المتطابقات والمعادلات',
                'subject_id' => $subject_1_1->id,
                'prerequisites' => []
            ],
            [
                'name' => 'الدوال الخطية والتربيعية',
                'subject_id' => $subject_1_1->id,
                'prerequisites' => ['المتطابقات والمعادلات']
            ],
            [
                'name' => 'التحليل إلى عوامل',
                'subject_id' => $subject_1_1->id,
                'prerequisites' => []
            ],

            // second semester
            [
                'name' => 'المتجهات',
                'subject_id' => $subject_1_2->id,
                'prerequisites' => []
            ],
            [
                'name' => 'الدوال الأسية',
                'subject_id' => $subject_1_2->id,
                'prerequisites' => []
            ],
            [
                'name' => 'التحويلات الهندسية',
                'subject_id' => $subject_1_2->id,
                'prerequisites' => []
            ],
            [
                'name' => 'حل المعادلات الجبرية',
                'subject_id' => $subject_1_2->id,
                'prerequisites' => []
            ],
            [
                'name' => 'التباديل والتوافيق',
                'subject_id' => $subject_1_2->id,
                'prerequisites' => []
            ],
            [
                'name' => 'مبادئ الاحتمالات',
                'subject_id' => $subject_1_2->id,
                'prerequisites' => ['التباديل والتوافيق']
            ],


            // second Grade

            // first semester
            [
                'name' => 'النهايات',
                'subject_id' => $subject_2_1->id,
                'prerequisites' => []
            ],
            [
                'name' => 'المشتقة الأولى',
                'subject_id' => $subject_2_1->id,
                'prerequisites' => ['النهايات']
            ],
            [
                'name' => 'الدوال المثلثية',
                'subject_id' => $subject_2_1->id,
                'prerequisites' => []
            ],
            [
                'name' => 'البرهان الرياضي',
                'subject_id' => $subject_2_1->id,
                'prerequisites' => []
            ],
            [
                'name' => 'المصفوفات',
                'subject_id' => $subject_2_1->id,
                'prerequisites' => []
            ],
            [
                'name' => 'الاشتقاق الضمني',
                'subject_id' => $subject_2_1->id,
                'prerequisites' => []
            ],

            // second semester
            [
                'name' => 'اللوغاريتمات',
                'subject_id' => $subject_2_2->id,
                'prerequisites' => []
            ],
            [
                'name' => 'التكامل بالتعويض',
                'subject_id' => $subject_2_2->id,
                'prerequisites' => []
            ],
            [
                'name' => 'الهندسة الفراغية',
                'subject_id' => $subject_2_2->id,
                'prerequisites' => []
            ],
            [
                'name' => 'الدوال الزائدية',
                'subject_id' => $subject_2_2->id,
                'prerequisites' => []
            ],
            [
                'name' => 'التكامل غير المحدود',
                'subject_id' => $subject_2_2->id,
                'prerequisites' => ['المشتقة الأولى']
            ]
        ];

        foreach ($conceptsData as $conceptData) {
            $concept = $this->conceptModel->create([
                'name' => $conceptData['name'],
                'subject_id' => $conceptData['subject_id']
            ]);

            foreach ($conceptData['prerequisites'] as $prereqName) {
                $prereqConcept = $this->conceptRepo->findByName($prereqName);

                if ($prereqConcept) {
                    $this->conceptPrerequisiteModel->create([
                        'concept_id' => $concept->id,
                        'prerequisite_concept_id' => $prereqConcept->id
                    ]);
                }
            }
        }
    }
}

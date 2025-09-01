<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    public function __construct(protected Grade $gradeModel) {}
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = [
            ['name' => 'first'],
            ['name' => 'second'],
            ['name' => 'third']
        ];

        foreach ($grades as $grade) {
            $this->gradeModel->updateOrCreate(
                ['name' => $grade['name']],
                $grade                      
            );
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Concept;
use App\Models\ConceptPrerequisite;
use App\Repositories\Interfaces\ConceptRepoInterface;
use App\Repositories\Interfaces\GradeRepoInterface;
use App\Repositories\Interfaces\SubjectRepoInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ConceptImportController extends Controller
{
    public function __construct(
        protected Concept $conceptModel,
        protected ConceptPrerequisite $conceptPrerequisiteModel,
        protected SubjectRepoInterface $subjectRepo,
        protected ConceptRepoInterface $conceptRepo,
        protected GradeRepoInterface $gradeRepo
    ) {}


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv,txt'
        ]);

   $uploadDir = storage_path('app/imports');
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true); // أنشئه إذا مش موجود
}

$fullPath = $uploadDir . '/concepts.xlsx';
$request->file('file')->move($uploadDir, 'concepts.xlsx');

// ✨ تأكد
$fullPath = str_replace('\\', '/', $fullPath);

        // اقرأ الملف (Excel/CSV) بترميز سليم
        $reader = IOFactory::createReaderForFile($fullPath);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($fullPath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray(null, true, true, true); // مفاتيح A,B,C...



        // صف العناوين (الهيدر)
        $headerRow = array_shift($rows); // أول صف
        $map = $this->buildHeaderMap($headerRow);

        // تأكيد وجود الأعمدة المطلوبة
        foreach (['subject','grade','semester','concept','prerequisites'] as $reqKey) {
            if (!isset($map[$reqKey])) {
                    if (file_exists($fullPath)) {
                        unlink($fullPath);
                    }
                return response()->json(['message' => "العمود المطلوب مفقود في الهيدر: {$reqKey}"], 422);
            }
        }

        DB::beginTransaction();
        try {
            // تمريرة 1: إنشاء جميع المفاهيم (مثل السيدر اليدوي)
            // نجمع أيضًا البيانات الأصلية للتمرير الثاني
            $buffer = [];

            foreach ($rows as $idx => $row) {
                $rowNumber = $idx + 2; // لأن الهيدر هو الصف 1
                $subjectName = trim((string)($row[$map['subject']] ?? ''));
                $gradeRaw    = trim((string)($row[$map['grade']] ?? ''));
                $semRaw      = trim((string)($row[$map['semester']] ?? ''));
                $conceptName = trim((string)($row[$map['concept']] ?? ''));
                $prereqsRaw  = (string)($row[$map['prerequisites']] ?? '');

                if ($conceptName === '') {
                    throw new \RuntimeException("سطر {$rowNumber}: اسم المفهوم فارغ.");
                }

                $gradeKey = $this->normalizeGrade($gradeRaw);        // 'first' | 'second' أو مدخل كما هو
                $semKey   = $this->normalizeSemester($semRaw);       // 'first' | 'second'

                $grade = $this->gradeRepo->findByName($gradeKey);
                // dd($grade);
                if (!$grade) {
                    throw new \RuntimeException("سطر {$rowNumber}: لم يتم العثور على صف دراسي: {$gradeRaw} (mapped: {$gradeKey}).");
                }

                $subject = $this->subjectRepo->findSubject($subjectName, $grade->id, $semKey);
                if (!$subject) {
                    throw new \RuntimeException("سطر {$rowNumber}: لم يتم العثور على مادة '{$subjectName}' للصف '{$gradeKey}' والفصل '{$semKey}'.");
                }

                // مثل السيدر: ننشئ مباشرة (من دون تخطي)
                $concept = $this->conceptModel->create([
                    'name'       => $conceptName,
                    'subject_id' => $subject->id
                ]);

                $buffer[] = [
                    'rowNumber' => $rowNumber,
                    'concept'   => $concept,
                    'prereqs'   => $prereqsRaw
                ];
            }

            // تمريرة 2: إنشاء العلاقات prerequisites (بالاسم فقط مثل السيدر اليدوي)
            foreach ($buffer as $item) {
                $concept   = $item['concept'];
                $rowNumber = $item['rowNumber'];

                foreach ($this->splitPrereqs($item['prereqs']) as $prName) {
                    $pr = $this->conceptRepo->findByName($prName);
                    if ($pr) {
                        // نتجنب التكرار
                        $this->conceptPrerequisiteModel->firstOrCreate([
                            'concept_id'              => $concept->id,
                            'prerequisite_concept_id' => $pr->id
                        ]);
                    } else {
                        // محاكاة سلوك السيدر اليدوي: يتجاهل فقط إذا ما لقاها؟ (السيدر اليدوي كان يتحقق ثم ينشئ)
                        // سنطبّق نفس الشيء: إذا غير موجود، لا ننشئ علاقة ولا نفشل.
                        // لو بدك نفشل، استبدل بالسطر التالي:
                        // throw new \RuntimeException("سطر {$rowNumber}: لم يتم العثور على prerequisite بالاسم '{$prName}'.");
                    }
                }
            }

            DB::commit();
            if (file_exists($fullPath)) {
                 unlink($fullPath);
            }

            return response()->json([
                'message' => 'تم الاستيراد بنجاح',
                'inserted_concepts' => count($buffer)
            ], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            if (file_exists($fullPath)) {
                unlink($fullPath);
}

            return response()->json([
                'message' => 'فشل الاستيراد',
                'error'   => $e->getMessage()
            ], 422);
        }
    }


    private function buildHeaderMap(array $headerRow): array
    {
        $norm = fn($v) => $this->normalizeHeader((string)$v);

        $colByKey = []; // key => columnLetter
        foreach ($headerRow as $colLetter => $title) {
            $t = $norm($title);
            if (!$t) continue;
            if (!isset($colByKey[$t])) {
                $colByKey[$t] = $colLetter;
            }
        }
        return $colByKey;
    }


    private function normalizeHeader(string $value): ?string
    {
        $v = mb_strtolower(trim($value));

        $aliases = [
            'subject'        => ['subject'],
            'grade'          => ['grade'],
            'semester'       => ['semester'],
            'concept'        => ['concept'],
            'prerequisites'  => ['prerequisites'],
        ];

        foreach ($aliases as $key => $names) {
            if (in_array($v, $names, true)) {
                return $key;
            }
        }
        return null;
    }

    /**
     * توحيد الصف (العاشر/الحادي عشر → first/second) أو تركه كما هو إن كان أصلاً مُعتمدًا.
     */
    private function normalizeGrade(string $grade): string
{
    $g = trim(mb_strtolower($grade));

    return match($g) {
        'العاشر','عاشر','10','الصف العاشر','الصف10'
            => 'first',

        'الحادي عشر','حادي عشر','11','الصف الحادي عشر','الصف11'
            => 'second',

        'الثالث الثانوي','الثالث','12','الصف الثالث الثانوي','الصف12'
            => 'third',

        default => $grade, // اتركه كما هو (قد يكون أصلاً 'first' أو 'second' أو 'third')
    };
}


    /**
     * توحيد الفصل (الأول/الثاني → first/second).
     */
    private function normalizeSemester(string $sem): string
    {
        $s = trim(mb_strtolower($sem));
        return match($s) {
            'الاول','الأول','اول','1','الفصل الاول','الفصل الأول'   => 'first',
            'الثاني','٢','2','الفصل الثاني'                          => 'second',
            'first','second'                                          => $s,
            default                                                   => $sem, // اتركه كما هو إن كان متوافقًا مع الداتا
        };
    }

    /**
     * تقسيم المتطلبات، يدعم عدة فواصل (| , ; ،)
     */
    private function splitPrereqs(?string $cell): array
    {
        if (!$cell) return [];
        $cell = trim($cell);
        if ($cell === '') return [];

        // استبدال جميع الفواصل المحتملة بـ |
        $unified = str_replace(
            [',','؛','؛ ','؛',';','،','/','\\'],
            '|',
            $cell
        );

        $parts = array_map('trim', explode('|', $unified));
        return array_values(array_filter($parts, fn($p) => $p !== ''));
    }
}

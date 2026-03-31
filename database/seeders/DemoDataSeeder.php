<?php

namespace Database\Seeders;

use App\Models\Exam;
use App\Models\MockExam;
use App\Models\StudyRecord;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'テストユーザー',
                'password' => Hash::make('password'),
            ]
        );

        $examDefinitions = [
            [
                'name' => 'AWS Solutions Architect Associate',
                'exam_date' => now()->addMonths(2)->format('Y-m-d'),
                'subjects' => ['AWS基礎', 'コンピューティング', 'ネットワーク', 'セキュリティ'],
                'mock_names' => ['模試A', '模試B', '模試C', '模試D'],
            ],
            [
                'name' => '簿記2級',
                'exam_date' => now()->addMonths(3)->format('Y-m-d'),
                'subjects' => ['商業簿記', '工業簿記', '原価計算', '財務分析'],
                'mock_names' => ['模試1', '模試2', '模試3', '模試4'],
            ],
            [
                'name' => '宅建',
                'exam_date' => now()->addMonths(5)->format('Y-m-d'),
                'subjects' => ['権利関係', '宅建業法', '法令上の制限', '税・その他'],
                'mock_names' => ['春模試', '初夏模試', '夏模試', '直前模試'],
            ],
        ];

        foreach ($examDefinitions as $examIndex => $definition) {
            $exam = Exam::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'name' => $definition['name'],
                ],
                [
                'exam_date' => $definition['exam_date'],
                'passing_score' => 280 + ($examIndex * 20),
                'target_score' => 320 + ($examIndex * 20),
                ]
            );

            $mockExamIds = MockExam::where('exam_id', $exam->id)->pluck('id');

            if ($mockExamIds->isNotEmpty()) {
                DB::table('mock_subject_scores')->whereIn('mock_exam_id', $mockExamIds)->delete();
            }

            DB::table('mock_exams')->where('exam_id', $exam->id)->delete();
            DB::table('study_records')->where('exam_id', $exam->id)->delete();

            $this->seedStudyRecords($user->id, $exam, $definition['subjects'], $examIndex);
            $this->seedMockExams($exam, $definition['subjects'], $definition['mock_names'], $examIndex);
        }
    }

    private function seedStudyRecords(int $userId, Exam $exam, array $subjects, int $examIndex): void
    {
        for ($i = 0; $i < 21; $i++) {
            $minutes = 45 + (($i + 1 + $examIndex) % 6) * 20;

            StudyRecord::create([
                'user_id' => $userId,
                'exam_id' => $exam->id,
                'study_date' => now()->subDays(20 - $i)->format('Y-m-d'),
                'subject' => $subjects[$i % count($subjects)],
                'study_minutes' => $minutes,
                'memo' => $subjects[$i % count($subjects)] . ' の復習と問題演習',
            ]);
        }
    }

    private function seedMockExams(Exam $exam, array $subjects, array $mockNames, int $examIndex): void
    {
        foreach ($mockNames as $mockIndex => $mockName) {
            $baseScore = 55 + ($examIndex * 4) + ($mockIndex * 5);
            $scores = [];

            foreach ($subjects as $subjectIndex => $subject) {
                $scores[$subject] = min(100, $baseScore + ($subjectIndex * 3) + (($mockIndex + $subjectIndex) % 5));
            }

            $totalScore = array_sum($scores);
            $deviationValue = 52 + ($examIndex * 1.5) + ($mockIndex * 2.4);

            $mockExam = MockExam::create([
                'exam_id' => $exam->id,
                'name' => $mockName,
                'taken_at' => now()->subDays(60 - ($mockIndex * 14))->format('Y-m-d'),
                'total_score' => $totalScore,
                'deviation_value' => round($deviationValue, 1),
            ]);

            foreach ($scores as $subject => $score) {
                $mockExam->subjectScores()->create([
                    'subject' => $subject,
                    'score' => $score,
                ]);
            }
        }
    }
}

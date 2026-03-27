<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\MockExam;
use Illuminate\Support\Facades\DB;

class MockExamService
{
    /**
     * 一覧取得
     */
    public function list(Exam $exam)
    {
        return $exam->mockExams()
            ->with('subjectScores')
            ->latest()
            ->get();
    }

    /**
     * 作成（トランザクション）
     */
    public function create(Exam $exam, array $data)
    {
        return DB::transaction(function () use ($exam, $data) {
            $mockExam = $exam->mockExams()->create([
                'name' => $data['name'],
                'taken_at' => $data['taken_at'],
                'deviation_value' => $data['deviation_value'] ?? null,
            ]);

            $total = 0;

            foreach ($data['subjects'] as $index => $subject) {
                $score = $data['scores'][$index] ?? 0;
                $mockExam->subjectScores()->create([
                    'subject' => $subject,
                    'score' => $score,
                ]);
                $total += $score;
            }
            $mockExam->update([
                'total_score' => $total,
            ]);

            return $mockExam;
        });
    }

    /**
     * 更新（トランザクション）
     */
    public function update(MockExam $mockExam, array $data)
    {
        return DB::transaction(function () use ($mockExam, $data) {

            $mockExam->update([
                'name' => $data['name'],
                'taken_at' => $data['taken_at'],
                'deviation_value' => $data['deviation_value'] ?? null,
            ]);

            // 既存削除
            $mockExam->subjectScores()->delete();

            $total = 0;

            foreach ($data['subjects'] as $index => $subject) {

                $score = $data['scores'][$index] ?? 0;

                $mockExam->subjectScores()->create([
                    'subject' => $subject,
                    'score' => $score,
                ]);

                $total += $score;
            }

            $mockExam->update([
                'total_score' => $total,
            ]);

            return $mockExam;
        });
    }

    /**
     * 削除
     */
    public function delete(MockExam $mockExam)
    {
        $mockExam->delete();
    }
}

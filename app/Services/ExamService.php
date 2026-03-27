<?php

namespace App\Services;

use App\Models\Exam;
use App\Models\StudyRecord;
use Carbon\Carbon;

class ExamService
{
    /**
     * 試験一覧取得
     */
    public function list(int $userId)
    {
        return Exam::where('user_id', $userId)
            ->with('studyRecords')
            ->latest()
            ->get();
    }

    /**
     * 試験横断の学習サマリー
     */
    public function overallStats(int $userId): array
    {
        $records = StudyRecord::where('user_id', $userId);

        $weeklyLabels = [];
        $weeklyData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $weeklyLabels[] = $date->format('m/d');
            $weeklyData[] = StudyRecord::where('user_id', $userId)
                ->whereDate('study_date', $date)
                ->sum('study_minutes');
        }

        return [
            'total_minutes' => (clone $records)->sum('study_minutes'),
            'study_days' => (clone $records)->distinct('study_date')->count('study_date'),
            'weekly' => [
                'labels' => $weeklyLabels,
                'data' => $weeklyData,
            ],
        ];
    }

    /**
     * 作成
     */
    public function create(int $userId, array $data)
    {
        return Exam::create([
            'user_id' => $userId,
            'name' => $data['name'],
            'exam_date' => $data['exam_date'] ?? null,
            'passing_score' => $data['passing_score'] ?? null,
            'target_score' => $data['target_score'] ?? null,
        ]);
    }

    /**
     * 更新
     */
    public function update(Exam $exam, array $data)
    {
        $exam->update([
            'name' => $data['name'],
            'exam_date' => $data['exam_date'] ?? null,
            'passing_score' => $data['passing_score'] ?? null,
            'target_score' => $data['target_score'] ?? null,
        ]);

        return $exam;
    }

    /**
     * 削除
     */
    public function delete(Exam $exam)
    {
        $exam->delete();
    }
}

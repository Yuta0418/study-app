<?php

namespace App\Services;

use App\Models\Exam;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExamAnalysisService
{
    /**
     * サマリー
     */
    public function summary(Exam $exam)
    {
        $totalMinutes = $exam->studyRecords()->sum('study_minutes');

        return [
            'total_minutes' => $totalMinutes,
        ];
    }

    /**
     * 週間データ（直近7日）
     */
    public function weekly(Exam $exam)
    {
        $labels = [];
        $data = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);

            $minutes = $exam->studyRecords()
                ->whereDate('study_date', $date)
                ->sum('study_minutes');

            $labels[] = $date->format('m/d');
            $data[] = $minutes;
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }

    /**
     * 月別データ
     */
    public function monthly(Exam $exam)
    {
        $monthly = $exam->studyRecords()
            ->select(
                DB::raw('DATE_FORMAT(study_date, "%Y-%m") as month'),
                DB::raw('SUM(study_minutes) as total_minutes')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'labels' => $monthly->pluck('month'),
            'data' => $monthly->pluck('total_minutes'),
        ];
    }

    /**
     * GitHub風カレンダー（直近90日）
     */
    public function calendar(Exam $exam)
    {
        $start = Carbon::today()->subDays(90);

        return $exam->studyRecords()
            ->whereDate('study_date', '>=', $start)
            ->get()
            ->groupBy(function ($record) {
                return Carbon::parse($record->study_date)->format('Y-m-d');
            });
    }

    /**
     * レーダーチャート（最新模試）
     */
    public function continuity(Exam $exam, ?int $weeklyGoal = null)
    {
        $weeklyGoal = $weeklyGoal ?? ($exam->user->weekly_goal_days ?? 5);
        $labels = [];
        $weeklyDays = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $studiedMinutes = $exam->studyRecords()
                ->whereDate('study_date', $date)
                ->sum('study_minutes');

            $labels[] = $date->format('m/d');
            $weeklyDays[] = $studiedMinutes > 0 ? 1 : 0;
        }

        $studyDaysThisWeek = array_sum($weeklyDays);

        // 今日までの連続学習日数を計算
        $currentStreak = 0;
        for ($i = 0; $i <= 6; $i++) {
            $date = Carbon::today()->subDays($i);
            $minutes = $exam->studyRecords()
                ->whereDate('study_date', $date)
                ->sum('study_minutes');

            if ($minutes > 0) {
                $currentStreak++;
            } else {
                break;
            }
        }

        $achievementRate = round(min(100, ($studyDaysThisWeek / max($weeklyGoal, 1)) * 100));

        return [
            'labels' => $labels,
            'weekly_days' => $weeklyDays,
            'studyDaysThisWeek' => $studyDaysThisWeek,
            'currentStreak' => $currentStreak,
            'weeklyGoal' => $weeklyGoal,
            'achievementRate' => $achievementRate,
        ];
    }

    public function radar(Exam $exam)
    {
        $latestMock = $exam->mockExams()
            ->with('subjectScores')
            ->latest('taken_at')
            ->first();

        if (!$latestMock) {
            return [
                'labels' => [],
                'data' => [],
            ];
        }

        return [
            'labels' => $latestMock->subjectScores->pluck('subject'),
            'data' => $latestMock->subjectScores->pluck('score'),
        ];
    }

    /**
     * 科目別学習時間
     */
    public function subjectBreakdown(Exam $exam)
    {
        $subjects = $exam->studyRecords()
            ->select('subject', DB::raw('SUM(study_minutes) as total_minutes'))
            ->groupBy('subject')
            ->orderByDesc('total_minutes')
            ->get();

        return [
            'labels' => $subjects->pluck('subject'),
            'data' => $subjects->pluck('total_minutes'),
        ];
    }

    /**
     * 模試推移
     */
    public function mockTrend(Exam $exam)
    {
        $mocks = $exam->mockExams()
            ->orderBy('taken_at')
            ->get();

        return [
            'labels' => $mocks->pluck('taken_at')->map(fn ($date) => Carbon::parse($date)->format('m/d')),
            'scoreData' => $mocks->pluck('total_score'),
            'deviationData' => $mocks->pluck('deviation_value')->map(fn ($value) => $value !== null ? (float) $value : null),
            'passingScore' => $exam->passing_score,
            'targetScore' => $exam->target_score,
        ];
    }
}

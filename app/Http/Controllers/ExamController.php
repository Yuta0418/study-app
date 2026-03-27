<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Exam;
use App\Services\ExamService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreExamRequest;
use App\Http\Requests\UpdateExamRequest;

class ExamController extends Controller
{
    private ExamService $examService;

    public function __construct(ExamService $examService)
    {
        $this->examService = $examService;
    }

    public function index()
    {
        $this->authorize('viewAny', Exam::class);

        return view('exams.index');
    }

    public function list()
    {
        $this->authorize('viewAny', Exam::class);
        $exams = $this->examService->list(auth()->id());
        $overall = $this->examService->overallStats(auth()->id());

        return view('exams.list', compact('exams', 'overall'));
    }

    public function create()
    {
        return view('exams.create');
    }

    public function store(StoreExamRequest $request)
    {
        $this->authorize('create', Exam::class);

        $this->examService->create(auth()->id(), $request->validated());

        return redirect()->route('exams.index');
    }

    public function show(Exam $exam)
    {
        $this->authorize('view', $exam);
        // 直近90日
        $start = Carbon::today()->subDays(90);

        $records = $exam->studyRecords()
            ->whereDate('study_date', '>=', $start)
            ->orderBy('study_date', 'desc')
            ->get();

        $totalMinutes = $records->sum('study_minutes');
        $studyDays = $records->unique('study_date')->count();

        // 週間グラフ
        $weeklyLabels = [];
        $weeklyData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $minutes = $exam->studyRecords()->whereDate('study_date', $date)->sum('study_minutes');
            $weeklyLabels[] = ['日', '月', '火', '水', '木', '金', '土'][$date->dayOfWeek];
            $weeklyData[] = $minutes;
        }

        // 日別グラフ用データ
        $dailyData = $exam->studyRecords()
            ->whereDate('study_date', '>=', $start)
            ->selectRaw('study_date, SUM(study_minutes) as total_minutes')
            ->groupBy('study_date')
            ->orderBy('study_date')
            ->get();

        $chartLabels = $dailyData->pluck('study_date');
        $chartData = $dailyData->pluck('total_minutes');
        // 月別グラフ
        $monthly = $exam->studyRecords()
            ->select(
                DB::raw('DATE_FORMAT(study_date, "%Y-%m") as month'),
                DB::raw('SUM(study_minutes) as total_minutes')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $monthlyLabels = $monthly->pluck('month');
        $monthlyData = $monthly->pluck('total_minutes');

        // GitHub風カレンダー用データ
        $calendarData = [];
        $dailyMap = $dailyData->keyBy('study_date');

        for ($i = 0; $i <= 90; $i++) {
            $date = $start->copy()->addDays($i)->format('Y-m-d');
            $minutes = isset($dailyMap[$date]) ? $dailyMap[$date]->total_minutes : 0;

            $calendarData[] = [
                'date' => $date,
                'minutes' => $minutes
            ];
        }

        // 最新の模試
        $latestMock = $exam->mockExams()
            ->with('subjectScores')
            ->orderByDesc('taken_at')
            ->first();

        $radarLabels = [];
        $radarData = [];
        $latestScore = null;
        $passingScoreDiff = null;
        $targetScoreDiff = null;

        if ($latestMock) {
            $radarLabels = $latestMock->subjectScores->pluck('subject');
            $radarData = $latestMock->subjectScores->pluck('score');
            $latestScore = $latestMock->total_score;
            $passingScoreDiff = $exam->passing_score !== null ? $latestScore - $exam->passing_score : null;
            $targetScoreDiff = $exam->target_score !== null ? $latestScore - $exam->target_score : null;
        }

        return view('exams.show', compact(
            'exam',
            'records',
            'totalMinutes',
            'studyDays',
            'chartLabels',
            'chartData',
            'weeklyLabels',
            'weeklyData',
            'monthlyLabels',
            'monthlyData',
            'calendarData',
            'latestMock',
            'radarLabels',
            'radarData',
            'latestScore',
            'passingScoreDiff',
            'targetScoreDiff'
        ));
    }

    public function edit(Exam $exam)
    {
        $this->authorize('update', $exam);

        return view('exams.edit', compact('exam'));
    }

    public function update(UpdateExamRequest $request, Exam $exam)
    {
        $this->authorize('update', $exam);

        $this->examService->update($exam, $request->validated());

        return redirect()->route('exams.show', $exam);
    }

    public function destroy(Exam $exam)
    {
        $this->authorize('delete', $exam);

        $this->examService->delete($exam);

        return redirect()
            ->route('exams.index')
            ->with('success', '試験を削除しました');
    }
}

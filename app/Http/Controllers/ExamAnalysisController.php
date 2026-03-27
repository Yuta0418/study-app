<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Services\ExamAnalysisService;

class ExamAnalysisController extends Controller
{

    private ExamAnalysisService $analysisService;

    public function __construct(ExamAnalysisService $analysisService)
    {
        $this->analysisService = $analysisService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Exam $exam)
    {
        $this->authorize('view', $exam);

        $summary = $this->analysisService->summary($exam);
        $weekly = $this->analysisService->weekly($exam);
        $monthly = $this->analysisService->monthly($exam);
        $calendar = $this->analysisService->calendar($exam);
        $radar = $this->analysisService->radar($exam);
        $continuity = $this->analysisService->continuity($exam);
        $subjectBreakdown = $this->analysisService->subjectBreakdown($exam);
        $mockTrend = $this->analysisService->mockTrend($exam);

        return view('analysis.index', compact(
            'exam',
            'summary',
            'weekly',
            'monthly',
            'calendar',
            'radar',
            'continuity',
            'subjectBreakdown',
            'mockTrend'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

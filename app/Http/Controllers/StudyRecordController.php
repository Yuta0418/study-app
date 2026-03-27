<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\StudyRecord;
use App\Services\StudyRecordService;
use App\Http\Requests\StoreStudyRecordRequest;
use App\Http\Requests\UpdateStudyRecordRequest;

class StudyRecordController extends Controller
{
    private StudyRecordService $studyRecordService;

    public function __construct(StudyRecordService $studyRecordService)
    {
        $this->studyRecordService = $studyRecordService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Exam $exam)
    {
        // 試験の所有者かどうかを確認
        $this->authorize('view', $exam);

        $records = $this->studyRecordService->list($exam);

        return view('study-records.index', compact('records', 'exam'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Exam $exam)
    {
        $this->authorize('view', $exam);

        return view('study-records.create', compact('exam'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreStudyRecordRequest $request, Exam $exam)
    {
        $this->authorize('update', $exam);

        $this->studyRecordService->create($exam, $request->validated());

        return redirect()->route('exams.study-records.index', $exam)->with('success', '学習記録を登録しました');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Exam $exam, StudyRecord $studyRecord)
    {
        $this->authorize('update', $exam);

        return view('study-records.edit', compact('exam', 'studyRecord'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudyRecordRequest $request, Exam $exam, StudyRecord $studyRecord)
    {
        $this->authorize('update', $exam);

        $this->studyRecordService->update($studyRecord, $request->validated());

        return redirect()->route('exams.study-records.index', $exam)->with('success', '更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam, StudyRecord $studyRecord)
    {
        $this->authorize('delete', $exam);

        $this->studyRecordService->delete($studyRecord);

        return redirect()->route('exams.show', $exam)->with('success', '削除しました');
    }
}

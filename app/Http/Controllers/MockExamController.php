<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\MockExam;
use App\Services\MockExamService;
use App\Http\Requests\StoreMockExamRequest;
use App\Http\Requests\UpdateMockExamRequest;

class MockExamController extends Controller
{
    /**
     * @var MockExamService
     */
    private $mockExamService;

    public function __construct(MockExamService $mockExamService)
    {
        $this->mockExamService = $mockExamService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Exam $exam)
    {
        $mockExams = $this->mockExamService->list($exam);

        return view('mock-exams.index', compact(
            'exam',
            'mockExams'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Exam $exam)
    {
        $this->authorize('update', $exam);

        return view('mock-exams.create', compact('exam'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMockExamRequest $request, Exam $exam)
    {
        $this->authorize('update', $exam);

        $this->mockExamService->create($exam, $request->validated());

        return redirect()->route('exams.mock-exams.index', $exam);
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
    public function edit(Exam $exam, MockExam $mockExam)
    {
        $this->authorize('update', $exam);

        if ($mockExam->exam_id !== $exam->id) {
            abort(404);
        }

        $mockExam->load('subjectScores');

        return view('mock-exams.edit', [
            'exam' => $exam,
            'mock' => $mockExam,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMockExamRequest $request, Exam $exam, MockExam $mockExam)
    {
        $this->authorize('update', $exam);

        if ($mockExam->exam_id !== $exam->id) {
            abort(404);
        }

        $this->mockExamService->update($mockExam, $request->validated());

        return redirect()->route('exams.mock-exams.index', $exam);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Exam $exam, MockExam $mockExam)
    {
        $this->authorize('delete', $exam);

        if ($mockExam->exam_id !== $exam->id) {
            abort(404);
        }

        $this->mockExamService->delete($mockExam);

        return redirect()->route('exams.mock-exams.index', $exam)->with('success', '削除しました');
    }
}

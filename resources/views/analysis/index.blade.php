@extends('layouts.app')

@section('content')

@php
    $analysisData = [
        'summary' => $summary,
        'continuity' => $continuity,
        'monthly' => $monthly,
        'weekly' => $weekly,
        'radar' => $radar,
        'mockTrend' => $mockTrend,
        'subjectBreakdown' => $subjectBreakdown,
    ];
@endphp

<div class="max-w-6xl mx-auto py-10 px-6 space-y-8">

    <!-- タイトル -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl text-white font-bold">
            {{ $exam->name }} 分析ダッシュボード
        </h1>
        <a href="{{ route('exams.show', $exam) }}" class="text-white hover:underline">
            ← 戻る
        </a>
    </div>

    <div
        id="analysis-dashboard"
        data-payload='@json($analysisData)'
    ></div>
</div>

@endsection

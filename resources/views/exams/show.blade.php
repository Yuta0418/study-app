@extends('layouts.app')

@section('content')

@php
    $header = '試験ダッシュボード';
@endphp

<div class="py-8 pb-8">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
        <a href="{{ route('exams.list') }}" class="inline-block text-gray-300 hover:underline">
            ← 試験一覧に戻る
        </a>

        <!-- Exam Header Card -->
        <div class="bg-white shadow rounded-xl p-6 mt-6">
            <h1 class="text-2xl font-bold mt-4">
                {{ $exam->name }}
            </h1>

            <p class="mt-2">
                試験日: {{ $exam->exam_date ?? '未設定' }}
            </p>

            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                <div class="rounded-lg bg-gray-50 px-4 py-3">
                    <p class="text-sm text-gray-500">合格基準点</p>
                    <p class="text-xl font-bold text-gray-800">
                        {{ $exam->passing_score !== null ? $exam->passing_score . ' 点' : '未設定' }}
                    </p>
                </div>
                <div class="rounded-lg bg-gray-50 px-4 py-3">
                    <p class="text-sm text-gray-500">目標得点</p>
                    <p class="text-xl font-bold text-gray-800">
                        {{ $exam->target_score !== null ? $exam->target_score . ' 点' : '未設定' }}
                    </p>
                </div>
            </div>

            @if($exam->exam_date)
            @php
                $today = \Carbon\Carbon::today();
                $examDate = \Carbon\Carbon::parse($exam->exam_date);
                $daysLeft = floor($today->diffInDays($examDate, false));
            @endphp

            <div class="mt-3 inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                {{ $daysLeft < 0 ? 'bg-red-100 text-red-700' : 'bg-indigo-100 text-indigo-700' }}">
                @if($daysLeft < 0)
                    試験終了
                @else
                    試験まであと {{ $daysLeft }} 日
                @endif
            </div>
            @endif

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-3 gap-3">

                <a href="{{ route('exams.study-records.create', $exam) }}" class="flex items-center justify-center gap-2 bg-indigo-600 px-4 py-3 rounded-xl shadow hover:bg-indigo-700 hover:scale-105 transition transform">
                    <span class="text-lg">＋</span>
                    <span class="font-semibold">学習記録</span>
                </a>

                <a href="{{ route('exams.study-records.index', $exam) }}" class="flex items-center justify-center gap-2 bg-gray-800 text-white px-4 py-3 rounded-xl shadow hover:bg-gray-900 hover:scale-105 transition transform">
                    <span class="text-lg">📋</span>
                    <span class="font-semibold">記録一覧</span>
                </a>

                <a href="{{ route('analysis.index', $exam) }}" class="flex items-center justify-center gap-2 bg-emerald-600 text-white px-4 py-3 rounded-xl shadow hover:bg-emerald-700 hover:scale-105 transition transform">
                    <span class="text-lg">📊</span>
                    <span class="font-semibold">分析</span>
                </a>

            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-1">
            <div class="bg-white shadow rounded-xl p-6 mt-4">
                <p class="text-sm">合計学習時間</p>
                <p class="text-3xl font-bold text-indigo-600 mt-2">
                    {{ $totalMinutes }} 分
                </p>
            </div>
            <div class="bg-white shadow rounded-xl p-6 mt-4">
                <p class="text-sm">学習日数</p>
                <p class="text-3xl font-bold text-indigo-600 mt-2">
                    {{ $studyDays }} 日
                </p>
            </div>
        </div>

        @if($latestMock)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-1">
            <div class="bg-white shadow rounded-xl p-6 mt-4">
                <p class="text-sm">最新模試得点</p>
                <p class="text-3xl font-bold text-emerald-600 mt-2">
                    {{ $latestScore }} 点
                </p>
            </div>
            <div class="bg-white shadow rounded-xl p-6 mt-4">
                <p class="text-sm">合格基準との差</p>
                <p class="text-3xl font-bold mt-2 {{ $passingScoreDiff !== null && $passingScoreDiff >= 0 ? 'text-emerald-600' : 'text-amber-600' }}">
                    {{ $passingScoreDiff !== null ? ($passingScoreDiff >= 0 ? '+' : '') . $passingScoreDiff . ' 点' : '未設定' }}
                </p>
            </div>
            <div class="bg-white shadow rounded-xl p-6 mt-4">
                <p class="text-sm">目標得点との差</p>
                <p class="text-3xl font-bold mt-2 {{ $targetScoreDiff !== null && $targetScoreDiff >= 0 ? 'text-emerald-600' : 'text-amber-600' }}">
                    {{ $targetScoreDiff !== null ? ($targetScoreDiff >= 0 ? '+' : '') . $targetScoreDiff . ' 点' : '未設定' }}
                </p>
            </div>
        </div>
        @endif

        <div class="bg-white shadow rounded-xl p-6 mt-4">
            <h2 class="text-lg font-semibold mb-4">直近7日学習時間</h2>
            <div style="height:250px;">
                <canvas id="weeklyChart"></canvas>
            </div>
        </div>

        <!-- Chart -->
        <div class="bg-white shadow rounded-xl p-6 mt-4">
            <h2 class="text-lg font-semibold mb-4">学習時間グラフ</h2>
            <div style="height:300px;">
                <canvas id="studyChart"></canvas>
            </div>
        </div>

        <!-- Monthly Chart -->
        <div class="bg-white shadow rounded-xl p-6 mt-4">
            <h2 class="text-lg font-semibold mb-4">月別学習時間</h2>
            <div style="height:300px;">
                <canvas id="monthlyChart"></canvas>
            </div>
        </div>

        <!-- GitHub風 学習カレンダー -->
        <div class="bg-white shadow rounded-xl p-6 mt-4">
            <h2 class="text-lg font-semibold mb-4">学習カレンダー</h2>

            <div class="grid grid-cols-7 gap-1 text-xs text-gray-500 mb-2">
                <div>日</div>
                <div>月</div>
                <div>火</div>
                <div>水</div>
                <div>木</div>
                <div>金</div>
                <div>土</div>
            </div>

            <div class="grid grid-cols-7 gap-1">

                @foreach($calendarData as $day)

                @php
                    $minutes = $day['minutes'];
                    $date = \Carbon\Carbon::parse($day['date']);
                    $dayOfWeek = $date->dayOfWeek;

                    if ($minutes == 0) {
                        $color = 'bg-gray-100';
                    } elseif ($minutes < 30) {
                        $color = 'bg-green-200';
                    } elseif ($minutes < 60) {
                        $color = 'bg-green-400';
                    } else {
                        $color = 'bg-green-600';
                    }
                @endphp
                <div class="{{ $color }} w-6 h-6 rounded-sm" title="{{ $day['date'] }}: {{ $minutes }}分">
                </div>
                @endforeach

            </div>

            <!-- 凡例 -->
            <div class="flex items-center gap-2 mt-4 text-xs">
                <span>少</span>
                <div class="w-4 h-4 bg-gray-100 rounded-sm"></div>
                <div class="w-4 h-4 bg-green-200 rounded-sm"></div>
                <div class="w-4 h-4 bg-green-400 rounded-sm"></div>
                <div class="w-4 h-4 bg-green-600 rounded-sm"></div>
                <span>多</span>
            </div>

        </div>

        <!-- レーダーチャート（模試 科目別） -->
        @if(isset($latestMock))
        <div class="bg-white shadow rounded-xl p-6 mt-4">
            <h2 class="text-lg font-semibold mb-4">最新模試（科目別）</h2>

            <div style="height:300px;">
                <canvas id="radarChart"></canvas>
            </div>
        </div>
        @endif

        <!-- Study Records -->
        <div class="bg-white shadow rounded-xl p-6 mt-4">
            <h2 class="text-lg font-semibold mb-4">学習履歴</h2>
            <div class="overflow-x-auto">
                <table class="w-full min-w-full border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 text-sm">
                        <tr>
                            <th class="px-4 py-2 text-center">日付</th>
                            <th class="px-4 py-2 text-center">科目</th>
                            <th class="px-4 py-2 text-center">時間(分)</th>
                            <th class="px-4 py-2 text-center">メモ</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                    @forelse($records as $record)
                        <tr class="border-t">
                            <td class="px-4 py-2 text-center">
                                {{ $record->study_date }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ $record->subject }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ $record->study_minutes }}
                            </td>
                            <td class="px-4 py-2 text-center">
                                {{ $record->memo }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-4 text-center">
                                学習記録がありません
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById('studyChart');
    const weeklyCanvas = document.getElementById('weeklyChart');
    const monthlyCanvas = document.getElementById('monthlyChart');
    const radarCanvas = document.getElementById('radarChart');

    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: '学習時間（分）',
                data: @json($chartData),
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });

    if (weeklyCanvas) {
        const weeklyCtx = weeklyCanvas.getContext('2d');
        new Chart(weeklyCtx, {
            type: 'bar',
            data: {
                labels: @json($weeklyLabels),
                datasets: [{
                    label: '学習時間（分）',
                    data: @json($weeklyData),
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }

    if (monthlyCanvas) {
        const monthlyCtx = monthlyCanvas.getContext('2d');
        new Chart(monthlyCtx, {
            type: 'bar',
            data: {
                labels: @json($monthlyLabels),
                datasets: [{
                    label: '月別学習時間（分）',
                    data: @json($monthlyData),
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    }
    if (radarCanvas) {
        const radarCtx = radarCanvas.getContext('2d');
        const radarLabels = @json($radarLabels ?? []);
        const radarData = @json($radarData ?? []);
        const latestMockChartType = radarLabels.length <= 2 ? 'bar' : 'radar';

        new Chart(radarCtx, {
            type: latestMockChartType,
            data: {
                labels: radarLabels,
                datasets: [{
                    label: 'スコア',
                    data: radarData,
                    backgroundColor: latestMockChartType === 'bar' ? 'rgba(79, 70, 229, 0.75)' : 'rgba(79, 70, 229, 0.2)',
                    borderColor: 'rgb(79, 70, 229)',
                    borderWidth: 2,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                scales: latestMockChartType === 'radar'
                    ? {
                        r: {
                            beginAtZero: true,
                            suggestedMax: 100
                        }
                    }
                    : {
                        y: {
                            beginAtZero: true,
                            suggestedMax: 100
                        }
                    }
            }
        });
    }
});
</script>

@endsection

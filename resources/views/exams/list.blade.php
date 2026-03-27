@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-8 px-4 bg-gray-700 rounded-xl shadow">

    <!-- ヘッダー -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-white">
            試験一覧
        </h1>
        <a href="{{ route('exams.create') }}" class="flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-xl shadow hover:bg-indigo-700 hover:scale-105 transition transform">
            <span class="text-lg">＋</span>
            <span class="font-semibold">試験作成</span>
        </a>
    </div>

    <!-- カード一覧 -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        @forelse ($exams as $exam)
        <div class="bg-white shadow rounded-xl p-6 hover:shadow-md transition">
            <h2 class="text-lg font-semibold text-gray-800 mb-2">
                {{ $exam->name }}
            </h2>
            <p class="text-sm text-gray-500 mb-4">
                試験日: {{ $exam->exam_date }}
            </p>
            <!-- 情報 -->
            <div class="flex justify-between text-sm mb-4">
                <div class="text-gray-600">
                    残り
                    <span class="font-bold text-indigo-600">
                        {{ floor(\Carbon\Carbon::today()->diffInDays($exam->exam_date, false)) }}
                    </span>
                    日
                </div>
                <div class="text-gray-600">
                    学習時間
                    <span class="font-bold text-emerald-600">
                        {{ $exam->studyRecords->sum('study_minutes') }}
                    </span>
                    分
                </div>
            </div>
            <!-- CTA -->
            <div class="grid grid-cols-2 gap-2 mb-2">
                <a href="{{ route('exams.mock-exams.index', $exam) }}" class="text-center bg-emerald-600 text-white py-2 rounded-lg hover:bg-emerald-700 transition">
                    模試一覧
                </a>

                <a href="{{ route('exams.mock-exams.create', $exam) }}" class="text-center bg-amber-500 text-white py-2 rounded-lg hover:bg-amber-600 transition">
                    模試作成
                </a>
            </div>

            <div class="grid grid-cols-3 gap-2">
                <a href="{{ route('exams.show', $exam) }}" class="text-center bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition">
                    詳細
                </a>

                <a href="{{ route('exams.edit', $exam) }}" class="text-center bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300 transition">
                    編集
                </a>

                <form action="{{ route('exams.destroy', $exam) }}" method="POST" onsubmit="return confirm('削除しますか？')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-500 text-white py-2 rounded-lg hover:bg-red-600 transition">
                        削除
                    </button>
                </form>
            </div>
        </div>
        @empty
        <!-- 空状態 -->
        <div class="col-span-full">
            <div class="bg-white shadow rounded-xl p-12 text-center">
                <h2 class="text-xl font-semibold mb-2">
                    試験がありません
                </h2>
                <p class="text-gray-500 mb-6">
                    最初の試験を作成して学習を管理しましょう
                </p>
                <a href="{{ route('exams.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-6 py-3 rounded-xl shadow hover:bg-indigo-700 hover:scale-105 transition transform">
                    <span class="text-lg">＋</span>
                    <span class="font-semibold">試験を作成</span>
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- 全体サマリー -->
    <div class="bg-white shadow rounded-xl p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
            <div class="grid grid-cols-2 gap-4 md:w-80">
                <div class="rounded-xl bg-indigo-50 p-4">
                    <p class="text-sm text-gray-500 mb-1">合計学習時間</p>
                    <p class="text-2xl font-bold text-indigo-600">{{ number_format($overall['total_minutes']) }} 分</p>
                </div>
                <div class="rounded-xl bg-emerald-50 p-4">
                    <p class="text-sm text-gray-500 mb-1">学習日数</p>
                    <p class="text-2xl font-bold text-emerald-600">{{ $overall['study_days'] }} 日</p>
                </div>
            </div>

            <div class="flex-1">
                <div class="flex items-center justify-between mb-3">
                    <h2 class="text-lg font-semibold text-gray-800">全試験合計の直近7日</h2>
                    <p class="text-sm text-gray-500">学習時間（分）</p>
                </div>
                <div style="height: 220px;">
                    <canvas id="overallStudyChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
new Chart(document.getElementById('overallStudyChart'), {
    type: 'line',
    data: {
        labels: @json($overall['weekly']['labels']),
        datasets: [{
            label: '学習時間（分）',
            data: @json($overall['weekly']['data']),
            borderColor: 'rgb(79, 70, 229)',
            backgroundColor: 'rgba(79, 70, 229, 0.12)',
            fill: true,
            tension: 0.35
        }]
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

@endsection

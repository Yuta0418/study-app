@extends('layouts.app')

@section('content')

    <div class="max-w-7xl mx-auto py-8 px-4">

        <!-- ヘッダー -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-white">
                    模試一覧
                </h1>
                <p class="text-sm text-white">
                    {{ $exam->name }}
                </p>
            </div>

            <div class="flex items-center gap-2">
                <!-- 戻る -->
                <a href="{{ route('exams.show', $exam->id) }}" class="text-sm bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                    ← 戻る
                </a>

                <!-- CTA -->
                <a href="{{ route('exams.mock-exams.create', $exam) }}" class="flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-xl shadow hover:bg-indigo-700 hover:scale-105 transition transform">
                    <span class="text-lg">＋</span>
                    <span class="font-semibold">模試追加</span>
                </a>
            </div>
        </div>

        <!-- 一覧 -->
        <div class="space-y-4">
            @forelse ($mockExams as $mock)
            <div class="bg-white shadow rounded-xl p-6 hover:shadow-md transition">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-lg font-semibold text-gray-800">
                            {{ $mock->name }}
                        </p>
                        <p class="text-sm text-gray-500">
                            受験日: {{ $mock->taken_at }}
                        </p>
                        <div class="mt-2 flex gap-4 text-sm">
                            <span class="text-gray-600">
                                総合得点: <span class="font-semibold text-indigo-600">{{ $mock->total_score }}</span> 点
                            </span>
                            <span class="text-gray-600">
                                偏差値: <span class="font-semibold text-emerald-600">{{ $mock->deviation_value ?? '-' }}</span>
                            </span>
                        </div>
                    </div>

                    <!-- 操作 -->
                    <div class="flex gap-2">
                        <a href="{{ route('exams.mock-exams.edit', [$exam, $mock]) }}" class="text-sm bg-yellow-400 px-3 py-1 rounded hover:bg-yellow-500 transition">
                            編集
                        </a>
                        <form action="{{ route('exams.mock-exams.destroy', [$exam, $mock]) }}" method="POST" onsubmit="return confirm('削除しますか？')">
                            @csrf
                            @method('DELETE')
                            <button class="text-sm bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                削除
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <!-- 空状態 -->
            <div class="bg-white shadow rounded-xl p-12 text-center">
                <p class="text-gray-400 mb-4">
                    模試データがまだありません
                </p>
                <a href="{{ route('exams.mock-exams.create', $exam) }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-3 rounded-xl shadow hover:bg-indigo-700 hover:scale-105 transition transform">
                    <span class="text-lg">＋</span>
                    <span class="font-semibold">最初の模試を登録</span>
                </a>
            </div>
            @endforelse
        </div>
    </div>

@endsection

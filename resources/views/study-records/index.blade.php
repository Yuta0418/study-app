@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto py-8 px-4">
    <!-- ヘッダー -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-white">
                学習記録一覧
            </h1>
            <p class="text-sm text-white">
                {{ $exam->name ?? '' }}
            </p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('exams.show', $exam) }}" class="text-sm bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition">
                ← 戻る
            </a>
            <a href="{{ route('exams.study-records.create', $exam) }}" class="flex items-center gap-2 bg-indigo-600 text-white px-4 py-2 rounded-xl shadow hover:bg-indigo-700 hover:scale-105 transition transform">
                <span class="text-lg">＋</span>
                <span class="font-semibold">記録追加</span>
            </a>
        </div>
    </div>
    <!-- 一覧 -->
    <div class="bg-white shadow rounded-xl overflow-hidden">
        @if($records->isEmpty())
            <div class="p-12 text-center">
                <p class="text-gray-400 mb-4">
                    学習記録がまだありません
                </p>

                <a href="{{ route('exams.study-records.create', $exam) }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-3 rounded-xl shadow hover:bg-indigo-700 hover:scale-105 transition transform">
                    <span class="text-lg">＋</span>
                    <span class="font-semibold">最初の記録を追加</span>
                </a>
            </div>
        @else
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="px-4 py-3 text-left">日付</th>
                        <th class="px-4 py-3 text-left">科目</th>
                        <th class="px-4 py-3 text-left">時間</th>
                        <th class="px-4 py-3 text-left">メモ</th>
                        <th class="px-4 py-3 text-right">操作</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($records as $record)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            {{ $record->study_date }}
                        </td>
                        <td class="px-4 py-3 font-medium text-gray-800">
                            {{ $record->subject }}
                        </td>
                        <td class="px-4 py-3">
                            {{ $record->study_minutes }}分
                        </td>
                        <td class="px-4 py-3 text-gray-500">
                            {{ $record->memo }}
                        </td>
                        <td class="px-4 py-3 text-right flex justify-end gap-2">
                            <a href="{{ route('exams.study-records.edit', [$exam, $record]) }}" class="text-sm bg-yellow-400 px-3 py-1 rounded hover:bg-yellow-500 transition">
                                編集
                            </a>
                            <form method="POST" action="{{ route('exams.study-records.destroy', [$exam, $record]) }}" onsubmit="return confirm('削除しますか？')">
                                @csrf
                                @method('DELETE')
                                <button class="text-sm bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                    削除
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

    </div>
@endsection

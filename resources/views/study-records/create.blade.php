@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto py-10 px-6">
    <h1 class="text-2xl text-white font-bold mb-6">
        {{ $exam->name }} 学習記録登録
    </h1>
    <div class="bg-white shadow-lg rounded-xl p-8">
        <form action="{{ route('exams.study-records.store', $exam) }}" method="POST">
            @csrf
            <!-- 学習日 -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    学習日
                </label>
                <input type="date" name="study_date" value="{{ old('study_date') }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('study_date')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <!-- 科目 -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    科目
                </label>
                <input type="text" name="subject" value="{{ old('subject') }}" placeholder="例：IAM" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('subject')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <!-- 学習時間 -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    学習時間（分）
                </label>
                <input type="number" name="study_minutes" value="{{ old('study_minutes') }}" placeholder="60" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('study_minutes')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <!-- メモ -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    メモ
                </label>
                <textarea name="memo" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('memo') }}</textarea>
                @error('memo')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <!-- ボタン -->
            <div class="flex justify-between items-center mt-8">
                <a href="{{ route('exams.show', $exam->id) }}" class="text-gray-600 hover:underline">
                    ← 戻る
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    保存
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

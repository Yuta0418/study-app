@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto py-10 px-6">
    <h1 class="text-2xl font-bold mb-6">
        試験編集
    </h1>
    <div class="bg-white shadow-lg rounded-xl p-8">
        <form action="{{ route('exams.update', $exam) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- 試験名 -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    試験名
                </label>
                <input type="text" name="name" value="{{ old('name', $exam->name) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <!-- 試験日 -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    試験日
                </label>
                <input type="date" name="exam_date" value="{{ old('exam_date', $exam->exam_date) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                @error('exam_date')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>
            <div class="grid md:grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        合格基準点
                    </label>
                    <input type="number" name="passing_score" value="{{ old('passing_score', $exam->passing_score) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('passing_score')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        目標得点
                    </label>
                    <input type="number" name="target_score" value="{{ old('target_score', $exam->target_score) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    @error('target_score')
                        <p class="text-red-500 text-sm mt-1">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
            </div>
            <!-- ボタン -->
            <div class="flex justify-between items-center mt-8">
                <a href="{{ route('exams.index') }}" class="text-gray-600 hover:underline">
                    ← 戻る
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    更新
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

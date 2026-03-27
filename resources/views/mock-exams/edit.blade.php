@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto py-10 px-6">
    <h1 class="text-2xl font-bold mb-6 text-white">
        {{ $exam->name }} 模試編集
    </h1>
    <div class="bg-white shadow-lg rounded-xl p-8">
        <form action="{{ route('exams.mock-exams.update', [$exam, $mock]) }}" method="POST">
            @csrf
            @method('PUT')
            <!-- 模試名 -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">模試名</label>
                <input type="text" name="name" value="{{ old('name', $mock->name) }}" class="w-full border-gray-300 rounded-lg">
            </div>
            <!-- 受験日 -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">受験日</label>
                <input type="date" name="taken_at" value="{{ old('taken_at', $mock->taken_at) }}" class="w-full border-gray-300 rounded-lg">
            </div>
            <!-- 偏差値 -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">偏差値（任意）</label>
                <input type="number" name="deviation_value" value="{{ old('deviation_value', $mock->deviation_value) }}" step="0.1" min="0" max="100" class="w-full border-gray-300 rounded-lg" placeholder="例: 58.5">
            </div>
            <!-- 科目スコア -->
            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">
                    科目スコア
                </label>
                <div id="subjects-container">
                    @foreach ($mock->subjectScores as $score)
                    <div class="flex gap-2 mb-2">
                        <input type="text" name="subjects[]" value="{{ $score->subject }}" class="w-1/2 border-gray-300 rounded-lg">
                        <input type="number" name="scores[]" value="{{ $score->score }}" class="w-1/2 border-gray-300 rounded-lg">
                    </div>
                    @endforeach
                </div>
                <button type="button" onclick="addSubject()" class="mt-2 text-blue-600 hover:underline">
                    ＋ 科目追加
                </button>
            </div>
            <!-- ボタン -->
            <div class="flex justify-between mt-8">
                <a href="{{ route('exams.mock-exams.index', $exam) }}" class="text-gray-600 hover:underline">
                    ← 戻る
                </a>
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg">
                    更新
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function addSubject() {
    const container = document.getElementById('subjects-container');
    const html = `
        <div class="flex gap-2 mb-2">
            <input type="text" name="subjects[]" placeholder="科目"
                class="w-1/2 border-gray-300 rounded-lg">

            <input type="number" name="scores[]" placeholder="点数"
                class="w-1/2 border-gray-300 rounded-lg">
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
}
</script>

@endsection

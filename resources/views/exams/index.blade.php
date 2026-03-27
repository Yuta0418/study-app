@extends('layouts.app')

@section('content')

<div class="max-w-7xl mx-auto py-8 px-4">

    <!-- ウェルカムメッセージ -->
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-white mb-4">
            Study App へようこそ
        </h1>
        <p class="text-xl text-white">
            試験勉強を効率的に管理しましょう
        </p>
    </div>

    <!-- メインアクション -->
    <div class="bg-white shadow rounded-xl p-8 mb-12">
        <div class="text-center mb-8">
            <div class="text-6xl mb-4">📚</div>
            <h2 class="text-2xl font-semibold mb-4">試験を選んで学習を進めましょう</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">
                試験を作成したら、試験一覧から学習記録・進捗確認・模試の登録までまとめて管理できます。
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-4 max-w-3xl mx-auto">
            <a href="{{ route('exams.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-6 py-4 rounded-xl shadow hover:bg-indigo-700 hover:scale-105 transition transform w-full justify-center">
                <span class="text-lg">＋</span>
                <span class="font-semibold">試験を作成</span>
            </a>
            <a href="{{ route('exams.list') }}" class="inline-flex items-center gap-2 bg-gray-600 text-white px-6 py-4 rounded-xl shadow hover:bg-gray-700 hover:scale-105 transition transform w-full justify-center">
                <span class="text-lg">📋</span>
                <span class="font-semibold">試験一覧を見る</span>
            </a>
        </div>
    </div>

    <!-- クイックアクセス -->
    <div class="bg-white shadow rounded-xl p-8">
        <h2 class="text-xl font-semibold mb-6">クイックアクセス</h2>
        <div class="grid md:grid-cols-3 gap-4">
            <a href="{{ route('exams.create') }}" class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <span class="text-2xl">📝</span>
                <div>
                    <div class="font-medium">試験作成</div>
                    <div class="text-sm text-gray-500">新しい試験を追加</div>
                </div>
            </a>
            <a href="{{ route('exams.list') }}" class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <span class="text-2xl">📊</span>
                <div>
                    <div class="font-medium">試験一覧</div>
                    <div class="text-sm text-gray-500">模試登録や詳細確認に進む</div>
                </div>
            </a>
            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                <span class="text-2xl">👤</span>
                <div>
                    <div class="font-medium">プロフィール</div>
                    <div class="text-sm text-gray-500">設定を変更</div>
                </div>
            </a>
        </div>
    </div>

</div>

@endsection

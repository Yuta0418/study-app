@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto py-10 px-6">
    <h1 class="text-2xl text-white font-bold mb-6">
        パスワードリセット
    </h1>
    <div class="bg-white shadow-lg rounded-xl p-8">

        <!-- 説明 -->
        <p class="text-sm text-gray-500 mb-6 text-center">
            登録しているメールアドレスを入力すると、
            パスワード再設定用のリンクを送信します。
        </p>

        <!-- ステータス -->
        <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

        <!-- フォーム -->
        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <!-- メール -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    メールアドレス
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="example@email.com">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- CTA -->
            <button type="submit" class="w-full bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                リセットリンク送信
            </button>
        </form>

        <!-- 戻る導線 -->
        <div class="text-center text-sm text-gray-500 mt-6">
            <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">
                ログイン画面へ戻る
            </a>
        </div>

    </div>
</div>
@endsection

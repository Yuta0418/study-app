@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto py-10 px-6">
    <h1 class="text-2xl text-white font-bold mb-6">
        ログイン
    </h1>
    <div class="bg-white shadow-lg rounded-xl p-8">

        <!-- ステータス / エラー -->
        <x-auth-session-status class="mb-4" :status="session('status')" />
        <x-input-error :messages="$errors->all()" class="mb-4" />

        <!-- フォーム -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- メール -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    メールアドレス
                </label>
                <input type="email" name="email"
                    value="{{ old('email') }}" required autofocus class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="example@email.com">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- パスワード -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    パスワード
                </label>
                <input type="password" name="password" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="••••••••">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- オプション -->
            <div class="flex items-center justify-between text-sm mb-6">
                <label class="flex items-center gap-2 text-gray-600">
                    <input type="checkbox" name="remember" class="rounded border-gray-300">
                    ログイン状態を保持
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-indigo-500 hover:underline">
                        パスワード忘れ
                    </a>
                @endif
            </div>

            <!-- CTAボタン -->
            <button type="submit" class="w-full bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                ログイン
            </button>
        </form>

        <!-- 区切り -->
        <div class="flex items-center my-6">
            <div class="flex-grow border-t"></div>
            <div class="flex-grow border-t"></div>
        </div>

        <!-- 新規登録導線 -->
        <div class="text-center text-sm text-gray-500">
            アカウントをお持ちでない方
            <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline ml-1">
                新規登録
            </a>
        </div>

        <!-- デモログイン情報 -->
        <div class="mt-6 text-sm text-gray-600 text-center">
            <p class="font-semibold mb-1">デモログイン情報</p>
            <p>email: test@example.com</p>
            <p>password: password</p>
        </div>

    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')

<div class="max-w-2xl mx-auto py-10 px-6">
    <h1 class="text-2xl text-white font-bold mb-6">
        新規登録
    </h1>
    <div class="bg-white shadow-lg rounded-xl p-8">

        <!-- エラー -->
        @if ($errors->any())
            <ul class="mb-4 space-y-1 rounded-lg bg-red-50 px-4 py-3 text-sm text-red-600">
                @foreach ($errors->all() as $message)
                    <li>{{ $message }}</li>
                @endforeach
            </ul>
        @endif

        <!-- フォーム -->
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- 名前 -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    名前
                </label>
                <input type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="山田 太郎">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- メール -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    メールアドレス
                </label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="example@email.com">
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
                <p class="text-xs text-gray-400 mt-1">
                    8文字以上で入力してください
                </p>
            </div>

            <!-- パスワード確認 -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    パスワード確認
                </label>
                <input type="password" name="password_confirmation" required class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="••••••••">
                @error('password_confirmation')
                    <p class="text-red-500 text-sm mt-1">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- CTAボタン -->
            <button type="submit" class="w-full bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                アカウント作成
            </button>
        </form>

        <!-- ログイン導線 -->
        <div class="text-center text-sm text-gray-500 mt-6">
            すでにアカウントをお持ちの方
            <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline ml-1">
                ログイン
            </a>
        </div>

    </div>
</div>
@endsection

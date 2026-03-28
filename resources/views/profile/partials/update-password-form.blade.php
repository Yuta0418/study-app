<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            パスワード変更
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            セキュリティのため、十分に強いパスワードへ変更してください。
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password" class="block text-sm font-medium text-gray-700 mb-2">現在のパスワード</label>
            <input id="update_password_current_password" name="current_password" type="password" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="current-password">
            @if ($errors->updatePassword->get('current_password'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->updatePassword->first('current_password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password" class="block text-sm font-medium text-gray-700 mb-2">新しいパスワード</label>
            <input id="update_password_password" name="password" type="password" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="new-password">
            @if ($errors->updatePassword->get('password'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->updatePassword->first('password') }}</p>
            @endif
        </div>

        <div>
            <label for="update_password_password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">新しいパスワード（確認）</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" autocomplete="new-password">
            @if ($errors->updatePassword->get('password_confirmation'))
                <p class="text-red-500 text-sm mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</p>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                更新
            </button>

            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)" class="text-sm text-red-600">
                    更新しました。
                </p>
            @endif
        </div>
    </form>
</section>

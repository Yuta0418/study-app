<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            基本情報・学習目標
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            名前・メールアドレスに加えて、学習目標を設定できます。
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">名前</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required autofocus autocomplete="name">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">メールアドレス</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" required autocomplete="username">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-700">
                        メールアドレスが未認証です。

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            認証メールを再送する
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            認証メールを再送しました。
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label for="weekly_goal_days" class="block text-sm font-medium text-gray-700 mb-2">週間学習目標日数</label>
                <input id="weekly_goal_days" name="weekly_goal_days" type="number" min="1" max="7" value="{{ old('weekly_goal_days', $user->weekly_goal_days) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-sm text-gray-500">1週間で学習したい日数を設定します。</p>
                @error('weekly_goal_days')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="daily_goal_minutes" class="block text-sm font-medium text-gray-700 mb-2">1日の目標学習時間（分）</label>
                <input id="daily_goal_minutes" name="daily_goal_minutes" type="number" min="1" max="1440" value="{{ old('daily_goal_minutes', $user->daily_goal_minutes) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <p class="mt-1 text-sm text-gray-500">例: 90 を入力すると1日90分が目標になります。</p>
                @error('daily_goal_minutes')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                保存
            </button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >保存しました。</p>
            @endif
        </div>
    </form>
</section>

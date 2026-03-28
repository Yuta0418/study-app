<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            退会
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            退会すると、登録済みの試験・学習記録・模試データを含むアカウント情報は削除されます。
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >退会する</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-white">
                本当に退会しますか？
            </h2>

            <p class="mt-1 text-sm text-white">
                退会を実行すると元に戻せません。確認のため現在のパスワードを入力してください。
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">パスワード</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4 border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    placeholder="パスワード"
                />

                @if ($errors->userDeletion->get('password'))
                    <p class="text-red-500 text-sm mt-2">{{ $errors->userDeletion->first('password') }}</p>
                @endif
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    キャンセル
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    退会する
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>

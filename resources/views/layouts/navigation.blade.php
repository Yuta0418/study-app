<nav class="bg-white shadow-sm border-b">
    <div class="max-w-7xl mx-auto px-6 py-3 flex justify-between items-center">
        <!-- Left -->
        <div class="flex items-center gap-6">
            <a href="{{ route('exams.index') }}" class="text-xl font-bold text-indigo-600">
                Study App
            </a>

        </div>
        <!-- Right -->
        <div class="flex items-center gap-4">
            @if(Auth::check())
                <span class="text-sm text-gray-600">
                    {{ Auth::user()->name }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="text-sm bg-gray-200 px-3 py-1 rounded hover:bg-gray-300 transition">
                        ログアウト
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="text-sm bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 transition">
                    ログイン
                </a>
            @endif
        </div>
    </div>
</nav>

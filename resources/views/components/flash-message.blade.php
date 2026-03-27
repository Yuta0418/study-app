@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-transition class="fixed top-5 right-5 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-3">
        <span>{{ session('success') }}</span>
        <button @click="show = false" class="text-white font-bold">×</button>
    </div>
@endif

@if (session('error'))
    <div  x-data="{ show: true }" x-show="show" x-transition class="fixed top-5 right-5 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 flex items-center gap-3">
        <span>{{ session('error') }}</span>
        <button @click="show = false" class="text-white font-bold">×</button>
    </div>
@endif

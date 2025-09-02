<div class="flex justify-center items-center mb-5">
    @if (session('status'))
        <div
            x-data="{ show: true }"
            x-show="show"
            class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 flex items-center justify-between w-full max-w-lg"
        >
            <span>{{ session('status') }}</span>
            <button
                type="button"
                class="ml-2 text-green-700 hover:text-green-900"
                @click="show = false"
            >
                ✖
            </button>
        </div>
    @endif

    @if (session('error'))
        <div
            x-data="{ show: true }"
            x-show="show"
            class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4 flex items-center justify-between w-full max-w-lg"
        >
            <span>{{ session('error') }}</span>
            <button
                type="button"
                class="ml-2 text-red-700 hover:text-red-900"
                @click="show = false"
            >
                ✖
            </button>
        </div>
    @endif
</div>

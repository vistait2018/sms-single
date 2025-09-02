 <div class="mb-4 flex items-center">
        <div class="relative w-full">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                <!-- Heroicon: Magnifying Glass -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 
                           0 1110.5 3a7.5 7.5 
                           0 016.15 13.65z" />
                </svg>
            </span>
            <input type="text" wire:model.live.debounce.500ms="search"
                class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-300 
                       focus:ring-2 focus:ring-blue-500 focus:outline-none 
                       dark:bg-gray-800 dark:border-gray-700 dark:text-gray-200"
                placeholder="{{ $placeholder }}" />
        </div>
    </div>
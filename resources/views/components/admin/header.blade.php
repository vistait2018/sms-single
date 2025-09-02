 <div class="flex justify-between items-center mb-5 px-3">
        <p class="flex gap-3 text-purple-500 items-center">
            <!-- Heroicon: Users -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 19.128a9.38 9.38 0 01-3 .497 9.38 9.38 0 01-3-.497M12 
                       12a4.5 4.5 0 100-9 4.5 4.5 0 000 9zm0 
                       0c2.5 0 7.5 1.25 7.5 3.75V18a.75.75 
                       0 01-.75.75H5.25A.75.75 0 014.5 18v-2.25C4.5 
                       13.25 9.5 12 12 12z" />
            </svg>
           {{ $title }}
        </p>

        <!-- ➕ Add User Button -->
        <button class="hover:text-purple-300" x-on:click="$dispatch('open-modal', '{{ $action }}')">
            <!-- Heroicon: Plus Circle -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v6m3-3H9m12 0a9 9 
                       0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
        </button>
    </div>
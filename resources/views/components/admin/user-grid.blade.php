<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($users as $user)
    <div
        class="bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-md transition p-4 flex items-center justify-between">
        <!-- User Info -->
        <div class="flex items-center space-x-3">
            <!-- Heroicon: User Circle -->
            <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.25 0 4.5 1.5 4.5 3.75v.75a.75.75
                               0 01-.75.75H8.25a.75.75
                               0 01-.75-.75v-.75C7.5
                               13.5 9.75 12 12 12zm0
                               0a3 3 0 100-6 3 3 0 000 6z" />
            </svg>
            <div>
              <div class="flex justify-around gap-2 items-center">
                    <p class="font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</p>

                <div class="flex items-center gap-1">
                    <!-- Heroicon: Lock Closed -->

               @if ($user->school)
    @if ($user->school->is_locked)
        <!-- 🔒 Locked → Unlock button -->
        <svg
            wire:click="unlock({{ $user->school->id }})"
            wire:confirm.prompt="Are you sure?\n\nType UNLOCK to confirm|UNLOCK"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="size-6 text-red-500 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75
                     11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25
                     2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25
                     2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
        </svg>
    @else
        <!-- 🔓 Unlocked → Lock button -->
        <svg
            wire:click="lock({{ $user->school->id }})"
            wire:confirm.prompt="Are you sure?\n\nType LOCK to confirm|LOCK"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="size-6 text-green-500 cursor-pointer">
            <path stroke-linecap="round" stroke-linejoin="round"
                  d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75
                     21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25
                     2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25
                     2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
        </svg>
    @endif
@else
    <!-- 🚫 No school assigned -->
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-purple-400">
  <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
</svg>

@endif

                </div>
             </div>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                <p class="text-xs text-gray-400 dark:text-gray-500 flex items-center gap-1">
                    <!-- Heroicon: Building Office -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5" />
                    </svg>

                    {{ $user->school->school_name ?? 'No School Assigned' }}
                </p>
            </div>
        </div>

        <!-- ⋮ Dropdown Actions -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none">
                <!-- Heroicon: Ellipsis Vertical -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.75a.75.75
                                   0 110-1.5.75.75
                                   0 010 1.5zm0
                                   6a.75.75
                                   0 110-1.5.75.75
                                   0 010 1.5zm0
                                   6a.75.75
                                   0 110-1.5.75.75
                                   0 010 1.5z" />
                </svg>
            </button>

            <!-- Dropdown -->
            <div x-show="open" @click.outside="open = false" x-transition
                class="absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg overflow-hidden z-50">
                <!-- Edit -->
                <button @click="$dispatch('open-modal', 'editUser-{{ $user->id }}'); open = false"
                    class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <!-- Heroicon: Pencil Square -->
                   <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 h-4 w-4">
  <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
</svg>

                   Edit Role
                </button>
                <!-- Lock -->
                {{-- <button
                    class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200">
                    <!-- Heroicon: Lock Closed -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V7.5a4.5 4.5
                                       0 10-9 0v3h-.75A1.5 1.5
                                       0 005.25 12v9A1.5 1.5
                                       0 006.75 22.5h10.5a1.5
                                       1.5 0 001.5-1.5v-9a1.5
                                       1.5 0 00-1.5-1.5H16.5z" />
                    </svg>
                    Lock
                </button> --}}
                <!-- Delete -->
                {{-- <button
                    class="flex items-center gap-2 w-full text-left px-4 py-2 text-sm hover:bg-red-100 dark:hover:bg-gray-700 text-red-600 dark:text-red-400">
                    <!-- Heroicon: Trash -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 7.5h12m-9 0V6a1.5
                                       1.5 0 013 0v1.5M9 10.5v6m6-6v6M4.5
                                       7.5l.75 12.75A1.5 1.5
                                       0 006.75 21.75h10.5a1.5
                                       1.5 0 001.5-1.5L19.5 7.5" />
                    </svg>
                    Delete
                </button> --}}
            </div>
        </div>
    </div>
    @empty
    <p class="text-gray-500 dark:text-gray-400">No users found.</p>
    @endforelse

    <!-- 📑 Pagination -->

</div>
<div class="mt-6">
    {{ $users->links() }}
</div>

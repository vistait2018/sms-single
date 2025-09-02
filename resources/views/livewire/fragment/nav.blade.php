<nav class="flex items-center justify-between px-4 py-3 bg-purple-900 text-gray-100 dark:bg-gray-700 shadow fixed top-0 left-0 right-0 z-20">
    @php
        $presentSchoolSession = getDecryptedSchoolSession();
       // dd($presentSchoolSession);
    @endphp

    <!-- Left -->
    <div class="flex items-center space-x-3">
        <img src="https://flowbite.s3.amazonaws.com/logo.svg" alt="logo" class="h-8 w-auto" />
        <span class="font-semibold text-lg">{{ env('APP_NAME','EDUCO-SMS') }}</span>

        <!-- Hamburger (mobile only) -->
        <button id="hamburgerBtn" class="ml-3 p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 lg:hidden">
            <svg xmlns="http://www.w3.org/2000/svg" id="hamburgerIcon" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Right -->
    <div class="flex items-center space-x-4">
        <!-- Session Info -->
        <div class="hidden sm:flex flex-col text-right leading-tight">
            <p class="text-xs uppercase font-medium">
                {{ $presentSchoolSession?->start_year }} {{ $presentSchoolSession ?'/':'' }} {{ $presentSchoolSession?->end_year }} {{ $presentSchoolSession ?'Session':'' }}
            </p>
            <span class="text-[10px] text-gray-300">{{ $presentSchoolSession ?'Term:':'' }} {{ $presentSchoolSession?->term }}</span>
        </div>

        <!-- Dark mode toggle -->
        <button id="darkModeToggle" class="p-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700">
            <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 block dark:hidden" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 3v1m0 16v1m8.66-9H21m-18 0h1m12.02 7.07l.7.71m-12.02-12.02l.7.71m12.02-.71l-.7.71M6.34 17.66l-.7.71" />
            </svg>
            <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 hidden dark:block" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 12.79A9 9 0 1111.21 3a7 7 0 009.79 9.79z" />
            </svg>
        </button>

        <!-- User Info + Avatar -->
        @auth
            <div class="relative">
                <button id="avatarBtn" class="flex items-center gap-2 focus:outline-none">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-medium">{{ auth()->user()->name }}</p>
                        <span class="text-xs text-gray-300">
                            {{ Auth::user()->roles->isNotEmpty() ? Auth::user()->roles->pluck('name')->join(', ') : 'No Role' }}
                        </span>
                    </div>
                    <img src="https://i.pravatar.cc/40" alt="avatar" class="w-8 h-8 rounded-full" />
                </button>

                <!-- Dropdown -->
                <div id="avatarMenu"
                    class="hidden absolute right-0 mt-2 w-40 bg-white dark:bg-gray-700 shadow rounded-md">
                    <a href="{{ route('profile') }}"
                        class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">Profile</a>

                    <button wire:click="logout"
                        class="w-full text-left block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600">
                        Logout
                    </button>
                </div>
            </div>
        @endauth
    </div>
</nav>

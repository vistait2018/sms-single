<div class="p-6">
    <!-- Flash Messages -->
    @if (session('status'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-700">
        {{ session('status') }}
    </div>
    @endif

    @if (session('error'))
    <div class="mb-4 p-3 rounded bg-red-100 text-red-700">
        {{ session('error') }}
    </div>
    @endif

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-xl font-bold text-gray-800 dark:text-gray-200">School Session Manager</h1>
        @if ($showStartSession)
        <button wire:confirm.prompt="You are about to start a new Session?\n\nType START to confirm|START" wire:click="addYear"
            class="px-4 py-2  bg-purple-600 text-white rounded-lg hover:bg-purple-700">
            <div class="flex gap-2">
<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 ">
  <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
</svg>

            
            </div>
        </button>
        @endif
    </div>

    <!-- Current Active Session -->
    @if ($presentSession)
    <div class="mb-6 p-4  bg-gray-50 dark:bg-gray-800 rounded-lg shadow">

        <div class="flex gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6  text-purple-500">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
            </svg>
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-300"> Active Session</h2>
        </div>


        <p class="mt-2 text-gray-600 dark:text-gray-400">
            {{ $presentSession->start_year }} / {{ $presentSession->end_year }} <br>
            Current Term: <span class="font-semibold capitalize">{{ $presentSession->term }}</span>
        </p>

        <div class="mt-4">
            
            @if ($presentSession->term !== 'third')
            <button wire:confirm.prompt="Are you sure?\n\nType END to confirm|END" wire:click="endCurrentTerm"
                class="px-4 py-2 bg-blue-700 text-white rounded-lg hover:bg-blue-600">
               <div class="flex gap-2"> <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-gray-200">
  <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
</svg>
<span> End {{ ucfirst($presentSession->term) }} Term</span>
</div>
            </button>
            @else
            <button wire:confirm.prompt="Are you sure you want to end Session?\n\nType END to confirm|END" wire:click="endCurrentTerm"
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                🛑 End Session
            </button>
            @endif
        </div>
    </div>
    @endif

    <!-- Search -->
    <div class="mb-4">
        <input type="text" wire:model.debounce.500ms="search" placeholder="Search session by year..."
            class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300 dark:bg-gray-900 dark:text-gray-100">
    </div>

    <!-- List of Sessions -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse">
            <thead class="bg-gray-100 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-2">Start Year</th>
                    <th class="px-4 py-2">End Year</th>
                    <th class="px-4 py-2">Term</th>
                    <th class="px-4 py-2">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($years as $year)
                <tr class="border-b dark:border-gray-700">
                    <td class="px-4 py-2">{{ $year->start_year }}</td>
                    <td class="px-4 py-2">{{ $year->end_year }}</td>
                    <td class="px-4 py-2 capitalize">{{ $year->term }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 rounded text-white 
                                {{ $year->status === 'active' ? 'bg-green-600' : 'bg-gray-500' }}">
                            {{ ucfirst($year->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-3 text-center text-gray-500 dark:text-gray-400">
                        No sessions found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4">
            {{ $years->links() }}
        </div>
    </div>
</div>
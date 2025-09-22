<div class="max-w-6xl mx-auto p-4">
    {{-- header --}}
    <div class="mb-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Set Weeks for a Term</h1>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                Active Year:
                <span class="font-medium text-gray-800 dark:text-gray-100">
                    {{ $activeYear ? ($activeYear->start_year . ' - ' . $activeYear->end_year) : 'Not set' }}
                </span>
                — choose a term and define how many weeks it will contain.
            </p>
        </div>

        <div class="w-full sm:w-auto">
            @if (session()->has('success'))
                <div class="px-3 py-2 rounded-md bg-green-50 dark:bg-green-900 text-green-700 dark:text-green-100">
                    {{ session('success') }}
                </div>
            @elseif (session()->has('error'))
                <div class="px-3 py-2 rounded-md bg-red-50 dark:bg-red-900 text-red-700 dark:text-red-100">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>

    {{-- main layout: form (left) | weeks (right) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- FORM --}}
        <div class="col-span-1 bg-white dark:bg-gray-800 p-4 rounded-2xl shadow">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-3">Create Weeks</h2>

            <form wire:submit.prevent="saveWeeks" class="space-y-4">
                {{-- term --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Term</label>
                    <select wire:model="term"
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-purple-500">
                        <option value="">-- Select Term --</option>
                        <option value="first">First Term</option>
                        <option value="second">Second Term</option>
                        <option value="third">Third Term</option>
                    </select>
                    @error('term') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- number --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Number of Weeks</label>
                    <input type="number" min="1" max="52" wire:model.defer="numberOfWeeks"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-900 dark:text-gray-200 focus:ring-2 focus:ring-purple-500 p-2" />
                    @error('numberOfWeeks') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        Set how many weeks will be available for the selected term (permanent for this term/year).
                    </p>
                </div>

                <div class="flex items-center gap-2">
                    <button type="submit"
                            wire:loading.attr="disabled"
                            class="flex-1 inline-flex justify-center items-center px-4 py-2 rounded-md bg-purple-600 text-white hover:bg-purple-700 focus:ring-2 focus:ring-purple-400">
                        <span wire:loading.remove>Save Weeks</span>
                        <span wire:loading>Saving...</span>
                    </button>

                    <button type="button" wire:click="$reset(['term','numberOfWeeks'])"
                            class="px-4 py-2 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                        Reset
                    </button>
                </div>
            </form>
        </div>

        {{-- WEEKS LIST --}}
        <div class="col-span-2 space-y-4">
            @if($weeks->isEmpty())
                <div class="p-4 bg-white dark:bg-gray-800 rounded-2xl shadow text-center">
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        No weeks created yet for the active year. Use the form to create them.
                    </p>
                </div>
            @endif

            {{-- group by term --}}
            @foreach($weeks as $termName => $termWeeks)
                <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow">
                    <div class="flex items-center justify-between">
                        <h3 class="text-md font-semibold text-gray-800 dark:text-gray-100">
                            {{ ucfirst($termName) }} Term
                        </h3>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Total: <span class="font-medium">{{ $termWeeks->count() }}</span> week(s)
                        </div>
                    </div>

                    <div class="mt-3 grid grid-cols-2 sm:grid-cols-4 gap-2">
                        @foreach($termWeeks as $week)
                            <div class="flex items-center justify-between gap-2 p-2 rounded-md border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-md bg-purple-50 dark:bg-purple-900 text-purple-700 dark:text-purple-200 font-medium">
                                        {{ $week->number }}
                                    </span>
                                    <div class="text-sm">
                                        <div class="font-medium text-gray-800 dark:text-gray-100">Week {{ $week->number }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-300">
                                            Created: {{ $week->created_at->format('M j, Y') }}
                                        </div>
                                    </div>
                                </div>

                                <button
                                    onclick="confirm('Delete week {{ $week->number }}? This will remove any associated notes.') || event.stopImmediatePropagation()"
                                    wire:click="deleteWeek({{ $week->id }})"
                                    class="inline-flex items-center justify-center px-2 py-1 rounded-md bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-200 text-xs">
                                    Delete
                                </button>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

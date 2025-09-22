<div class="max-w-6xl mx-auto p-4 space-y-6">
    {{-- Messages --}}
    <x-admin.message-component />

    {{-- Title --}}
    <h1 class="text-2xl font-bold text-center text-gray-900 dark:text-gray-100 mb-4">
        Lesson Notes - {{ ucfirst($term) }} Term
    </h1>

    {{-- Search --}}
    <div class="mb-4 w-full text-center">
        <input type="text" wire:model.live="search" placeholder="Search level..." class="w-full sm:w-1/2 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600
                      dark:bg-gray-900 text-gray-800 dark:text-gray-200 focus:ring-2 focus:ring-purple-500">
    </div>

    {{-- Levels Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($levels as $level)
        <div class="bg-white dark:bg-gray-800 p-4 rounded-2xl shadow flex flex-col">
            <h2 class="text-lg font-semibold text-purple-600 dark:text-purple-400 mb-3">
                {{ $level->name }}
            </h2>

            {{-- Weeks --}}
            <div class="space-y-3">
                @foreach($weeks[$term] ?? [] as $week)
                @php
                $note = $level->lessonNotes->where('week', $week->number)->first();
                @endphp

                <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 rounded-lg px-3 py-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-200">
                        Week {{ $week->number }}
                    </span>

                    @if($note)
                    <div class="flex items-center gap-2 flex-wrap">
                        <a href="{{ asset('storage/'.$note->note_url) }}" target="_blank"
                            class="px-2 py-1 text-xs rounded bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 hover:underline">
                            View
                        </a>
                        <a href="{{ asset('storage/'.$note->note_url) }}" download
                            class="px-2 py-1 text-xs rounded bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-200 hover:underline">
                            Download
                        </a>
                        <button wire:click="removeNote({{ $note->id }})"
                            class="px-2 py-1 text-xs rounded bg-red-500 text-white hover:bg-red-600">
                            Remove
                        </button>
                    </div>
                    @else
                    <button wire:click="selectWeek({{ $level->id }}, {{ $week->number }})"
                        class="px-3 py-1 rounded-lg bg-purple-600 text-white text-xs font-medium hover:bg-purple-700">
                        Upload
                      </button>
                        @endif
                </div>
                @endforeach
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $levels->links() }}
    </div>

    {{-- Upload Modal --}}
    @if($selectedLevel && $selectedWeek)

    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-xl">
            <h2 class="text-lg font-bold text-purple-600 dark:text-purple-400 mb-4">
                Upload Lesson Note - {{ $selectedLevel->name }} (Week {{ $selectedWeek }})
            </h2>
            <form wire:submit.prevent="uploadNote" class="space-y-4"    >
            <input type="file" wire:key="file-{{ $selectedWeek }}" wire:model="noteFile"
                class="w-full text-sm text-gray-700 dark:text-gray-200 border border-gray-300 dark:border-gray-600 dark:bg-gray-900 rounded-lg focus:ring-2 focus:ring-purple-500 mb-4">
            <x-input-error class="mt-2" :messages="$errors->get('noteFile')" />
            <div class="flex flex-col sm:flex-row gap-2">
                <button type="submit"
                    class="flex-1 px-4 py-2 rounded-lg bg-purple-600 text-white font-medium hover:bg-purple-700">
                    Save
                </button>


                <button type="button" wire:click="cancelUpload"
                    class="flex-1 px-4 py-2 rounded-lg bg-gray-400 dark:bg-gray-600 text-white font-medium hover:bg-gray-500 dark:hover:bg-gray-500">
                    Cancel
                </button>
                <!-- Loading -->
                <div wire:loading wire:target="uploadNote"
                    class="w-full text-center text-sm text-purple-600 dark:text-purple-400 mt-2">
                    Saving lesson note...
                </div>
            </form>
            </div>
        </div>
    </div>
    @endif

</div>

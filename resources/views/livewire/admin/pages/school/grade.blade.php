<div class="space-y-6">
    {{-- Flash Message --}}
    <x-admin.message-component />

    {{-- Create Form --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 space-y-4">
        <h2 class="text-lg font-semibold text-purple-700 dark:text-purple-300">Add New Grade</h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
                <input type="text" wire:model.defer="grade_name"
                       placeholder="Grade Name"
                       class="w-full p-2 rounded-md border border-purple-200
                              bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-100" />
                @error('grade_name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <input type="number" min="0" max="100" wire:model.defer="min_level"
                       placeholder="Min Level"
                       class="w-full p-2 rounded-md border border-purple-200
                              bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-100" />
                @error('min_level') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <input type="number" min="0" max="100" wire:model.defer="max_level"
                       placeholder="Max Level"
                       class="w-full p-2 rounded-md border border-purple-200
                              bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-100" />
                @error('max_level') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <button wire:click="createGrade"
                class="px-4 py-2 rounded-lg font-semibold shadow
                       bg-purple-600 text-white hover:bg-purple-700
                       dark:bg-purple-500 dark:hover:bg-purple-600">
            Create Grade
        </button>
    </div>

    {{-- Search --}}
    <div class="flex items-center">
        <input type="text" wire:model.live="search"
               placeholder="Search grades..."
               class="w-full sm:w-1/3 p-2 rounded-md border border-purple-200
                      bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-100" />
    </div>

    {{-- Grades Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @php
            $max = $grades->max('max_level');
            $min = $grades->min('min_level');
        @endphp

        @foreach($grades as $grade)
            @php
                $bgColor = $grade->max_level == $max
                    ? 'bg-green-500 text-white'
                    : ($grade->min_level == $min
                        ? 'bg-red-500 text-white'
                        : 'bg-purple-500 text-white');
            @endphp

            <div class="p-4 rounded-xl shadow {{ $bgColor }}">
                @if($editingId === $grade->id)
                    {{-- Edit Form --}}
                    <input type="text" wire:model.defer="edit_grade_name"
                           class="w-full mb-2 p-2 rounded text-gray-800" />
                    @error('edit_grade_name') <p class="text-xs text-red-500">{{ $message }}</p> @enderror

                    <div class="flex gap-2">
                        <div class="flex-1">
                            <input type="number" min="0" max="100" wire:model.defer="edit_min_level"
                                   class="w-full p-2 rounded text-gray-800" />
                            @error('edit_min_level') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                        <div class="flex-1">
                            <input type="number" min="0" max="100" wire:model.defer="edit_max_level"
                                   class="w-full p-2 rounded text-gray-800" />
                            @error('edit_max_level') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-2 flex gap-2">
                        <button wire:click="updateGrade"
                                class="px-3 py-1 rounded bg-green-600 text-white hover:bg-green-700">
                            Save
                        </button>
                        <button wire:click="cancelEdit"
                                class="px-3 py-1 rounded bg-gray-600 text-white hover:bg-gray-700">
                            Cancel
                        </button>
                    </div>
                @else
                    {{-- Display --}}
                    <h3 class="text-lg font-bold italic">{{ $grade->grade_name }}</h3>
                    <p class="text-sm mt-1">Range: {{ $grade->min_level }} - {{ $grade->max_level }}</p>
                    <p class="text-xs opacity-80 mt-2">Created: {{ $grade->created_at->diffForHumans() }}</p>

                    <button wire:click="startEdit({{ $grade->id }})"
                            class="mt-2 px-3 py-1 rounded bg-white text-purple-700 font-semibold hover:bg-gray-100">
                        Edit
                    </button>
                @endif
            </div>
        @endforeach
    </div>

    <div>
        {{ $grades->links() }}
    </div>
</div>

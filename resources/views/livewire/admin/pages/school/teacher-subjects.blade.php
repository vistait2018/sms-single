<div class="max-w-4xl mx-auto p-4 space-y-6">
    {{-- Search + Filter --}}
    <div class="flex flex-col sm:flex-row gap-2">
        <input type="text" wire:model.live.debounce.300ms="search"
               class="w-full rounded-lg border-gray-300 py-2 px-3
                      dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                      focus:ring-2 focus:ring-purple-500"
               placeholder="Search by Last Name...">

        <select wire:model="sex"
                class="rounded-lg border-gray-300 py-2 px-3
                       dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                       focus:ring-2 focus:ring-purple-500">
            <option value="">All Sex</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>
    </div>

    @if($show)
        <x-admin.message-component class="w-full" />

        {{-- Teacher List --}}
        <div class="grid grid-cols-1 gap-4">
            @foreach($teachers as $teacher)
                <div wire:click="selectTeacher({{ $teacher->id }})"
                     class="p-4 rounded-2xl shadow-md cursor-pointer
                            bg-white dark:bg-gray-800
                            hover:bg-purple-50 dark:hover:bg-gray-700
                            transition-all duration-200 flex items-start gap-4">

                    {{-- Avatar --}}
                    <div class="flex-shrink-0">
                        <div class="w-14 h-14 rounded-full bg-purple-600 flex items-center justify-center text-white font-bold text-lg shadow-md">
                            {{ strtoupper(substr($teacher->first_name, 0, 1)) }}{{ strtoupper(substr($teacher->last_name, 0, 1)) }}
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="flex-1">
                        <p class="font-semibold text-lg text-gray-900 dark:text-gray-100">
                            {{ $teacher->last_name }} {{ $teacher->first_name }} {{ $teacher->middle_name }}
                        </p>

                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Sex: <span class="font-medium text-gray-900 dark:text-gray-100">{{ $teacher->sex }}</span>
                        </p>

                        @if($teacher->levels()->where('active', true)->exists())
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Class Teacher:
                                <span class="font-medium text-purple-600 dark:text-purple-400">
                                    {{ $teacher->levels()->where('active', true)->first()->name }}
                                </span>
                            </p>
                        @endif

                        {{-- Subjects --}}
                        @if($teacher->subjects->count())
                            <div class="text-sm text-gray-600 dark:text-gray-400 mt-2">
                                <p class="font-medium mb-1">Subjects & Classes:</p>
                               <div class="flex flex-wrap gap-3">
    @foreach($teacher->subjects as $subject)
        <div class="flex items-center gap-2">
            <span class="px-2 py-1 rounded-lg bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300">
                {{ $subject->name }}
            </span>
            <span class="text-gray-500 dark:text-gray-400 text-xs">
                ({{ $subject->pivot->level?->name ?? 'No Class' }})
            </span>
        </div>
    @endforeach
</div>

                            </div>
                        @else
                            <p class="italic text-gray-500 dark:text-gray-400">None Assigned</p>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

         <div>{{ $teachers->links() }}</div> 

        {{-- Department + Subjects --}}
        @if($selectedTeacher)
            <div class="mt-6 space-y-4">
                <h2 class="text-xl font-bold text-purple-600 dark:text-purple-400">
                    Assign Subjects to {{ $selectedTeacher->last_name }}
                </h2>

                {{-- Select Department --}}
                <select wire:model.live="selectedDepartment"
                        class="w-full py-2 px-3 rounded-lg border-gray-300
                               dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                               focus:ring-2 focus:ring-purple-500">
                    <option value="">Select Department</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                </select>

                {{-- Select Class --}}
                <select wire:model.live="selectedLevel"
                        class="w-full py-2 px-3 rounded-lg border-gray-300
                               dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                               focus:ring-2 focus:ring-purple-500">
                    <option value="">Select Class</option>
                    @foreach($levels as $level)
                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>

                {{-- Subjects --}}
                @if($subjects)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                        @foreach($subjects as $subject)
                            <label class="flex items-center gap-2 p-3 rounded-lg
                                          bg-gray-100 dark:bg-gray-700 cursor-pointer
                                          hover:bg-purple-50 dark:hover:bg-gray-600">
                                <input type="checkbox"
                                       wire:click="toggleSubject({{ $subject['id'] }})"
                                       @checked($subject['checked'])
                                       class="text-purple-600 focus:ring-purple-500 rounded">
                                <span class="text-gray-900 dark:text-gray-100">{{ $subject['name'] }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <button wire:click="saveChanges"
                                class="px-4 py-2 rounded-lg bg-purple-600 text-white
                                       hover:bg-purple-700 focus:ring-2 focus:ring-purple-500">
                            Save Changes
                        </button>
                        <span wire:loading wire:target="saveChanges" class="text-xs text-purple-500">Saving...</span>
                    </div>
                @endif
            </div>
        @endif
    @else
        <p class="text-center text-gray-600 dark:text-gray-400">No teachers found.</p>
    @endif
</div>

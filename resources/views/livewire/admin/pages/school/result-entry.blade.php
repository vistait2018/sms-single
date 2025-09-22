<div class="space-y-6">
    {{-- Flash Message --}}
    <x-admin.message-component class="w-full" />

    {{-- Select Level --}}
    <div>
        <label for="level" class="block text-sm font-medium text-purple-700 dark:text-purple-300">
            Select Level | {{ $selectedLevelName ?? 'No Level Selected' }}
        </label>
        <select id="level" wire:model.live.debounce.500ms="selectedLevel" class="mt-1 p-2 block w-full rounded-md border border-purple-200 shadow-sm
                   focus:border-purple-500 focus:ring-purple-500
                   bg-gray-100 text-gray-600 dark:bg-gray-600 dark:border-gray-600 dark:text-gray-100
                   dark:focus:border-purple-400 dark:focus:ring-purple-400">
            <option value="">-- Select Level --</option>
            @foreach($levels as $level)
            <option value="{{ $level->id }}">{{ $level->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Select Subject --}}
    @if($selectedLevel)
    <div>
        <label for="subject" class="block text-sm font-medium text-purple-700 dark:text-purple-300">
            Select Subject
        </label>
        <select id="subject" wire:model.live.debounce.500ms="selectedSubject" class="mt-1 p-2 block w-full rounded-md border border-purple-200 shadow-sm
                       focus:border-purple-500 focus:ring-purple-500
                       bg-gray-100 text-gray-600 dark:bg-gray-600 dark:border-gray-600 dark:text-gray-100
                       dark:focus:border-purple-400 dark:focus:ring-purple-400">
            <option value="">-- Select Subject --</option>
            @foreach($subjects as $subject)
            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
        </select>
        @error('subject')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
    </div>
    @endif

    {{-- Student Table --}}
    @if($selectedSubject)
    <div class="overflow-x-auto dark:bg-gray-700 rounded-md p-2">
        <table class="min-w-full border border-purple-200 divide-y divide-purple-200
                          dark:divide-gray-700 shadow rounded-md overflow-hidden">
            <thead class="bg-purple-600 text-white dark:bg-purple-700">
                <tr>
                    <th class="border border-purple-200 px-2 py-2 text-left text-sm font-semibold">SN</th>
                    <th class="border border-purple-200 px-2 py-2 text-left text-sm font-semibold">Name</th>
                    <th class="border border-purple-200 px-2 py-2 text-left text-sm font-semibold">CA</th>
                    <th class="border border-purple-200 px-2 py-2 text-left text-sm font-semibold flex gap-4">Exam Score
                        @if(!$edit)<svg wire:click="enableEdit" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="size-4 text-gray-100">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                        </svg>
                        @else
                        <svg  wire:click="disableEdit" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-4 text-gray-100">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>

                        @endif

                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-purple-100 dark:bg-gray-900 dark:divide-gray-800">
                @foreach($students as $index => $student)
                <tr class="hover:bg-purple-50 dark:hover:bg-gray-800">
                    <td class="border border-purple-200 px-2 py-2 text-sm text-gray-700 dark:text-gray-200">
                        {{ $index+1 }}
                    </td>
                    <td class="border border-purple-200 px-2 py-2 text-sm text-gray-700 dark:text-gray-200">
                        {{ $student->first_name }} {{ $student->last_name }}
                    </td>

                    {{-- CA --}}
                    <td class="border border-purple-200 px-2 py-2">
                        @if($edit)
                        <input type="number" min="0" max="{{ $ca_total ?? 40 }}"
                            wire:model.defer="scores.{{ $student->id }}.ca" class="w-24 rounded-md border border-purple-200 focus:border-purple-500 focus:ring-purple-500
                                                  dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100
                                                  dark:focus:border-purple-400 dark:focus:ring-purple-400">
                        <x-input-error :messages="$errors->get('scores.'.$student->id.'.ca')" />
                        @else
                        <span class="text-gray-700 dark:text-gray-200">
                            {{ $scores[$student->id]['ca'] ?? '' }}
                        </span>
                        @endif
                    </td>

                    {{-- Exam --}}
                    <td class="border border-purple-200 px-2 py-2">
                        @if($edit)
                        <input type="number" min="0" max="{{ $exam_total ?? 60 }}"
                            wire:model.defer="scores.{{ $student->id }}.exam" class="w-24 rounded-md border border-purple-200 focus:border-purple-500 focus:ring-purple-500
                                                  dark:bg-gray-800 dark:border-gray-600 dark:text-gray-100
                                                  dark:focus:border-purple-400 dark:focus:ring-purple-400">
                        <x-input-error :messages="$errors->get('scores.'.$student->id.'.exam')" />
                        @else
                        <span class="text-gray-700 dark:text-gray-200">
                            {{ $scores[$student->id]['exam'] ?? '' }}
                        </span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Save Button --}}
    <div class="pt-4">
        <button @disabled(!$edit)  wire:click="saveResults" class="px-6 py-2 rounded-xl font-semibold shadow
                       bg-purple-600 text-white hover:bg-purple-700
                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500
                       dark:bg-purple-500 dark:hover:bg-purple-600 dark:focus:ring-purple-400
                       {{ $edit ? '' : 'opacity-50 cursor-not-allowed' }}">
            {{ $edit ? 'Save Results' : 'Enable Editing' }}
        </button>
        @if($edit === true)
      <button wire:click="disableEdit"
    class="px-6 py-2 rounded-xl font-semibold shadow
           bg-red-600 text-white hover:bg-red-700
           focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500
           dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-400
           {{ $edit ? '' : 'opacity-50 cursor-not-allowed' }}">
    Cancel
</button>

        @endif
    </div>
    @endif
</div>

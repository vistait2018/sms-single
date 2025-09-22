<div class="p-4 max-w-7xl mx-auto">
    {{-- Search + Select --}}
    <div class="mb-4">
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search class..."
            class="w-full p-2 rounded-lg border dark:bg-gray-800 dark:text-gray-100 border-purple-400 focus:ring-2 focus:ring-purple-500" />

        <select wire:model.live.debounce.300ms="selectedLevel"
            class="w-full mt-3 p-2 rounded-lg border dark:bg-gray-800 dark:text-gray-100 border-purple-400 focus:ring-2 focus:ring-purple-500">
            <option value="">-- Select Class --</option>
            @foreach($levels as $level)
            <option value="{{ $level->id }}">{{ $level->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Student Table --}}
    @if($students)
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left border-collapse border border-purple-400 dark:border-gray-700">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="px-3 py-2">SN</th>
                    <th class="px-3 py-2">Name</th>
                    <th class="px-3 py-2">Sex</th>
                    <th class="px-3 py-2">Affective</th>
                    <th class="px-3 py-2">Psychomotor</th>
                    <th class="px-3 py-2">Comment</th>
                </tr>
            </thead>
            <tbody class="dark:bg-gray-800">
                @foreach($students as $index => $student)
                <tr class="border-t border-purple-300 dark:border-gray-700">
                    <td class="px-3 py-2">{{ $index+1 }}</td>
                    <td class="px-3 py-2">{{ $student->first_name }} {{ $student->last_name }}</td>
                    <td class="px-3 py-2">{{ $student->sex }}</td>
                    <td class="px-3 py-2">
                        @if($formData[$student->id]['saved_at'])
                        <div class="text-xs text-green-600 dark:text-green-400 mb-1">
                            Saved on {{ $formData[$student->id]['saved_at'] }}
                        </div>
                        @endif

                        <select wire:model="formData.{{ $student->id }}.affective_grade" title="affective grade"
                            class="p-1 rounded border dark:bg-gray-700 dark:text-gray-100 border-purple-300">
                            <option value="">--</option>
                            @for($i=1;$i<=5;$i++) <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                        </select>
                        @error("formData.$student->id.affective_grade")
    <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
@enderror
                    </td>
                    <td class="px-4 py-2">
                        @if($formData[$student->id]['saved_at'])
                        <div class="text-xs text-green-600 dark:text-green-400 mb-1">
                            Saved on {{ $formData[$student->id]['saved_at'] }}
                        </div>
                        @endif

                        <select wire:model="formData.{{ $student->id }}.psychomotor_grade" title="psychomotor grade"
                            class="p-1 rounded border dark:bg-gray-700 dark:text-gray-100 border-purple-300">
                            <option value="">--</option>
                            @for($i=1;$i<=5;$i++) <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                        </select>
                        @error("formData.$student->id.psychomotor_grade")
    <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
@enderror
                    </td>
                    <td class="px-4 py-2">
                        @if($formData[$student->id]['saved_at'])
                        <div class="text-xs text-green-600 dark:text-green-400 mb-1">
                            Saved on {{ $formData[$student->id]['saved_at'] }}
                        </div>
                        @endif

                        <select wire:model="formData.{{ $student->id }}.comment" title="comment"
                            class="w-full p-1 rounded border dark:bg-gray-700 dark:text-gray-100 border-purple-300">
                            <option value="">--</option>
                            @foreach($comments as $comment)
                            <option value="{{ $comment->comment }}">{{ $comment->comment }}</option>
                            @endforeach
                        </select>
                        @error("formData.$student->id.comment")
    <div class="text-xs text-red-600 mt-1">{{ $message }}</div>
@enderror
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  {{-- Save Button --}}
    <div class="mt-4">
        <button wire:click="save"
            class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow disabled:opacity-50 disabled:cursor-not-allowed"
            >
            Save
        </button>
    </div>

    @endif

    {{-- Flash Message --}}
    @if(session('success'))
    <div class="mt-3 text-green-600 dark:text-green-400">
        {{ session('success') }}
    </div>
    @endif
</div>

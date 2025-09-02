<div class="p-4 space-y-6">
    <x-admin.message-component class="w-full" />

    <!-- Add New Class -->
   <div class="flex flex-col gap-4">
    <!-- Input + Department + Button -->
    <div class="flex flex-col sm:flex-row sm:items-end gap-3">
        
        <!-- Class Name Input -->
        <div class="flex-1">
             <label class="text-sm font-semibold block mb-1">Add Class</label>
            <input type="text" 
                   wire:model="newClassName" 
                   placeholder="Enter new class name"
                   class="w-full border text-gray-500 rounded-lg p-2 text-sm" />
            <x-input-error :messages="$errors->get('newClassName')" />
        </div>

        <!-- Select Department -->
        <div class="flex-1">
            <label class="text-sm font-semibold block mb-1">Department</label>
            <select wire:model="selectedDepartment" 
                    class="w-full border rounded-lg p-2 text-sm text-gray-500">
                <option value="">-- Select Department --</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Add Button -->
        <div>
            <button wire:click="addClass" 
                    class="w-full sm:w-auto px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                Add Class
            </button>
        </div>
    </div>
</div>

    <!-- Classes List -->
    <h2 class="text-lg font-bold">Classes</h2>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
        @foreach($classes as $class)
            <div wire:click="selectClass({{ $class->id }})"
                class="cursor-pointer border rounded-xl p-4 shadow-sm hover:shadow-md transition
                    {{ $selectedClass && $selectedClass->id === $class->id ? 'border-purple-500 bg-purple-50' : '' }}">
                <h3 class="font-semibold">{{ $class->name }}</h3>
                <p class="text-sm text-gray-500">{{ $class->students()->count() }} Students</p>
                <p class="text-xs text-gray-400">
                    {{ $class->departments()->pluck('name')->first() ?: 'No department' }}
                </p>
            </div>
        @endforeach
    </div>

    <!-- Students in Class -->
    @if($selectedClass)
        <div class="border-t pt-6 space-y-4">
            <h2 class="text-xl font-bold">
                Students in <span class="text-purple-600">{{ $selectedClass->name }}</span>
            </h2>

            <!-- Edit Department -->
            <div>
                <label class="text-sm font-semibold">Department for this Class</label>
                <select wire:model="editDepartment" class="w-full border rounded-lg p-2 text-sm text-gray-500">
                    <option value="">-- Select Department --</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                    @endforeach
                </select>
                <button  wire:confirm.prompt="Are you sure?\n\nType UPDATE to confirm|UPDATE" wire:click="updateClassDepartment"
                    class="mt-2 mb-3 divide-x-8 px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    Update Department
                </button>
            </div>

            <!-- Search Students -->
            <input type="text" wire:model="studentSearch" placeholder="Search students..."
                class="w-full border rounded-lg p-2 text-sm" />

            <!-- Students List -->
       <div class="overflow-x-auto rounded-lg border">
    <table class="min-w-full text-sm text-left text-gray-700">
        <thead class="bg-gray-300 text-gray-900 uppercase text-xs font-semibold">
            <tr>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Sex</th>
                <th class="px-4 py-3">Address</th>
                <th class="px-4 py-3">DOB</th>
                <th class="px-4 py-3">LIN No</th>
                <th class="px-4 py-3">Phone</th>
                <th class="px-4 py-3">LGA</th>
                <th class="px-4 py-3">State</th>
                <th class="px-4 py-3">Nationality</th>
                <th class="px-4 py-3">Religion</th>
                <th class="px-4 py-3">Prev. School</th>
                <th class="px-4 py-3">Email</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr class="odd:bg-purple-200 even:bg-gray-50 hover:bg-purple-50 transition-colors">
                    <td class="px-4 py-2 font-medium text-gray-900">
                        {{ strtoupper($student->last_name) }} {{ $student->middle_name }}
                    </td>
                    <td class="px-4 py-2">{{ $student->sex }}</td>
                    <td class="px-4 py-2">{{ $student->address ?? '--' }}</td>
                    <td class="px-4 py-2">{{ $student->dob ?? '--' }}</td>
                    <td class="px-4 py-2">{{ $student->lin_no ?? '--' }}</td>
                    <td class="px-4 py-2">{{ $student->phone_no ?? '--' }}</td>
                    <td class="px-4 py-2">{{ $student->lga ?? '--' }}</td>
                    <td class="px-4 py-2">{{ $student->state_of_origin ?? '--' }}</td>
                    <td class="px-4 py-2">{{ $student->national ?? '--' }}</td>
                    <td class="px-4 py-2">{{ $student->religion ?? '--' }}</td>
                    <td class="px-4 py-2">{{ $student->previous_school_name ?? '--' }}</td>
                    <td class="px-4 py-2 text-gray-500">{{ $student->user->email ?? '--' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="px-4 py-3 text-gray-500 text-center">
                        No students found
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>



            <div>
                {{ $students->links() }}
            </div>
        </div>
    @endif
</div>

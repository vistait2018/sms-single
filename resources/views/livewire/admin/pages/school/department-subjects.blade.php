<div class="p-4 space-y-6">
     <!-- Total Departments -->
    <div class="flex justify-between items-center">
        <h2 class="text-lg font-bold">
            Total Departments: <span class="text-green-600">{{ $totalDepartments }}</span>
        </h2>
    </div>
    <!-- Search Box -->
    <div class="flex justify-between  items-center w-full">
        <input type="text" wire:model.live.debounce.300ms="search"
            placeholder="Search departments..."
            class="w-full border rounded-lg p-2 text-gray-500 text-sm" />
    </div>

    <!-- Departments List -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
        @foreach($departments as $department)
            <div wire:click="selectDepartment({{ $department->id }})"
                class="cursor-pointer border rounded-xl p-4 shadow-sm hover:shadow-md transition
                       {{ $selectedDepartment && $selectedDepartment->id === $department->id ? 'border-blue-500 bg-blue-50' : '' }}">
                <h3 class="font-semibold text-lg">{{ $department->name }}</h3>
                <p class="text-sm text-gray-500">{{ $department->subjects()->count() }} Subjects</p>
            </div>
        @endforeach
    </div>

    <div>
        {{ $departments->links() }}
    </div>

    <!-- Department Subjects -->
    @if($selectedDepartment)
        <div class="border-t pt-6">
            <h2 class="text-xl font-bold mb-4">
                Manage Subjects for <span class="text-purple-600">{{ $selectedDepartment->name }}</span>
            </h2>

            @if (session()->has('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-3">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                @foreach($allSubjects as $subject)
                    <label class="flex items-center space-x-2 border p-2 rounded-lg">
                        <input type="checkbox" wire:model="selectedSubjects" value="{{ $subject->id }}" />
                        <span>{{ $subject->name }}</span>
                    </label>
                @endforeach
            </div>

            <button wire:click="saveSubjects"
                class="mt-4 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-blue-700">
                Save Changes
            </button>
        </div>
    @endif
</div>

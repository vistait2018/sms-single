<div class="p-4 sm:p-6 lg:p-8 bg-gray-100 dark:bg-gray-900 min-h-screen text-gray-900 dark:text-gray-100">
    <h1 class="text-2xl font-bold text-purple-700 dark:text-purple-400 mb-4">
        Assign Class Teachers
    </h1>

    <!-- Search -->
    <div class="mb-4">
        <input
            type="text"
            wire:model.live="search"
            placeholder="Search teacher..."
            class="w-full sm:w-1/2 p-2 rounded-lg border border-purple-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-2 focus:ring-purple-500"
        />
    </div>

    <x-admin.message-component class="w-full" />

    <!-- Responsive Table -->
    <div class="overflow-x-auto">
        <table class="w-full border border-purple-500 dark:border-purple-700 rounded-lg overflow-hidden">
            <thead class="bg-purple-700 text-white dark:bg-purple-600">
                <tr>
                    <th class="px-4 py-2 text-left">Name</th>
                    <th class="px-4 py-2 text-left">Sex</th>
                    <th class="px-4 py-2 text-left">Phone</th>
                    <th class="px-4 py-2 text-left">Assign to Class</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($teachers as $teacher)
                    <tr class="border-b border-gray-300 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-800">
                        <td class="px-4 py-2">
                            <div class="font-semibold">{{ $teacher->first_name }} {{ $teacher->last_name }}</div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">{{ $teacher->email }}</div>
                        </td>
                        <td class="px-4 py-2 capitalize">{{ $teacher->sex }}</td>
                        <td class="px-4 py-2">{{ $teacher->phone_no ?? '-' }}</td>
                        <td class="px-4 py-2">
    <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-2 space-y-2 sm:space-y-0 w-full">
        <select
            wire:model="selectedLevels.{{ $teacher->id }}"
            class="w-full sm:w-1/2 p-2 rounded-lg border border-purple-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100"
        >
            <option value="">-- Select Class --</option>
            @foreach ($levels as $level)
                <option value="{{ $level->id }}">
                    {{ $level->name }}
                </option>
            @endforeach
        </select>
        <button
            type="button"
            class="px-5 py-2 border border-purple-500 text-purple-700 dark:text-purple-300 rounded-lg hover:bg-purple-500 hover:text-white dark:hover:text-gray-100"
            wire:click="assignTeacher({{ $teacher->id }})">
            Set
        </button>
    </div>
</td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-600 dark:text-gray-400">
                            No teachers found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $teachers->links() }}
    </div>
</div>

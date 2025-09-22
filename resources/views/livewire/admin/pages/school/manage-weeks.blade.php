<div class="p-4 max-w-4xl mx-auto space-y-6">
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-2xl font-bold text-purple-700 dark:text-purple-300">Manage Weeks</h1>

        <div class="flex flex-col sm:flex-row gap-2 w-full sm:w-auto">
            <select wire:model="yearId"
                class="px-3 py-2 rounded-lg border border-purple-300 dark:border-purple-600 bg-white dark:bg-gray-800 text-sm w-full sm:w-auto">
                <option value="">Select Year</option>
                @foreach($years as $year)
                    <option value="{{ $year->id }}">
                        {{ $year->start_year }}/{{ $year->end_year }} - {{ ucfirst($year->term) }}
                    </option>
                @endforeach
            </select>

            <input type="date" wire:model="startDate"
                class="px-3 py-2 rounded-lg border border-purple-300 dark:border-purple-600 bg-white dark:bg-gray-800 text-sm w-full sm:w-auto">

            <button wire:click="generateWeeks"
                class="px-4 py-2 rounded-lg bg-purple-600 text-white font-medium hover:bg-purple-700 w-full sm:w-auto">
                Generate 13 Weeks
            </button>
        </div>
    </div>
 <x-admin.message-component class="w-full" />
    {{-- Weeks list --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300">
                <tr>
                    <th class="px-3 py-2 text-left">#</th>
                    <th class="px-3 py-2 text-left">Start</th>
                    <th class="px-3 py-2 text-left">End</th>
                </tr>
            </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
    @forelse($weeks as $week)

        <tr class="{{ $week->isCurrent ? 'bg-purple-50 dark:bg-purple-800' : '' }}">
            <td class="px-3 py-2 font-medium flex items-center gap-2">
                {{ $week->number }}
               
                @if($week->isCurrent)
                    <span class="text-xs px-2 py-1 rounded-full bg-green-600 text-white dark:bg-green-400 dark:text-gray-900">
                        Present
                    </span>
                @endif
            </td>
            <td class="px-3 py-2">{{ \Carbon\Carbon::parse($week->start_date)->format('d M, Y') }}</td>
            <td class="px-3 py-2">{{ \Carbon\Carbon::parse($week->end_date)->format('d M, Y') }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="3" class="px-3 py-4 text-center text-gray-500 dark:text-gray-400">
                No weeks generated.
            </td>
        </tr>
    @endforelse
</tbody>


        </table>
    </div>

    <div>
        {{ $weeks->links() }}
    </div>
</div>

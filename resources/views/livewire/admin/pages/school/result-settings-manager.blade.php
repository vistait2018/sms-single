<div class="space-y-6">
    {{-- Flash --}}
    <x-admin.message-component class="w-full" />

    {{-- Header --}}
    <div>
        <h2 class="text-lg font-semibold text-purple-700 dark:text-purple-300">
            Result Settings (Active Year Only)
        </h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            Active Year: {{ $presentTerm ? ucfirst($presentTerm) . ' Term' : 'N/A' }}
        </p>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto bg-purple-50 dark:bg-gray-900/50 rounded-lg p-2">
        <table class="min-w-full border-collapse table-auto">
            <thead class="bg-purple-600 text-white dark:bg-purple-700">
                <tr>
                    <th class="px-3 py-2 text-left text-sm font-medium border border-purple-500">Term</th>
                    <th class="px-3 py-2 text-left text-sm font-medium border border-purple-500">CA Total</th>
                    <th class="px-3 py-2 text-left text-sm font-medium border border-purple-500">Exam Total</th>
                    <th class="px-3 py-2 text-center text-sm font-medium border border-purple-500">Action</th>
                </tr>
            </thead>

            <tbody class="bg-white dark:bg-gray-800">
                @foreach($settings as $term => $setting)
                    <tr class="odd:bg-white even:bg-purple-50 dark:odd:bg-gray-800 dark:even:bg-gray-800/90">
                        <td class="border border-purple-200 px-3 py-2 text-sm text-gray-700 dark:text-gray-200">
                            {{ ucfirst($term) }} Term
                        </td>

                        <td class="border border-purple-200 px-3 py-2">
                            <input type="number"
                                   wire:model.defer="settings.{{ $term }}.ca_total"
                                   min="0"
                                   class="w-28 p-2 rounded-md border border-purple-200 focus:border-purple-500 focus:ring-purple-500
                                         bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-100"
                                   placeholder="e.g. 40">
                        </td>

                        <td class="border border-purple-200 px-3 py-2">
                            <input type="number"
                                   wire:model.defer="settings.{{ $term }}.exam_total"
                                   min="0"
                                   class="w-28 p-2 rounded-md border border-purple-200 focus:border-purple-500 focus:ring-purple-500
                                         bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-100"
                                   placeholder="e.g. 60">
                        </td>

                        <td class="border border-purple-200 px-3 py-2 text-center">
                            <button wire:click="saveTerm('{{ $term }}')"
                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-md font-medium
                                           bg-purple-600 text-white hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-400">
                                Save
                            </button>
                            @error('settings.' . $term . '.total')
        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
    @enderror
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p class="mt-2 text-xs text-gray-600 dark:text-gray-300">
            Tip: Each row saves independently for the active academic year.
        </p>
    </div>
</div>

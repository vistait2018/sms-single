<div class="max-w-6xl mx-auto p-4 space-y-6">
    {{-- Search --}}
    <div class="flex">
        <input type="text" wire:model.live.debounce.500ms="search"
               placeholder="Search teachers..."
               class="w-full rounded-lg border-gray-300 py-2 px-3
                      dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                      focus:ring-2 focus:ring-purple-500">
    </div>
 <x-admin.message-component class="w-full" />
    {{-- Teacher Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($teachers as $teacher)
        <div class="p-5 rounded-2xl shadow-md bg-white dark:bg-gray-800 flex flex-col">
            
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100">
                        {{ $teacher->first_name }} {{ $teacher->last_name }} {{ $teacher->middle_name }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Sex: {{ ucfirst($teacher->sex) }}
                    </p>
                </div>
                <span class="px-3 py-1 rounded-full bg-purple-100 dark:bg-purple-900 
                             text-purple-700 dark:text-purple-300 text-sm font-medium">
                    ₦{{ number_format($teacher->activeSalary->amount ?? 0, 2) }}
                </span>
            </div>

            {{-- Actions --}}
           {{-- Actions --}}
<div class="mt-4">
    @if($teacher->activeSalary && $teacher->activeSalary->amount > 0)
        <button wire:click="payTeacher({{ $teacher->id }})"
                class="w-full px-4 py-2 rounded-lg bg-purple-600 text-white font-medium
                       hover:bg-purple-700 focus:ring-2 focus:ring-purple-500">
            Pay
        </button>
    @else
        <button disabled
                class="w-full px-4 py-2 rounded-lg bg-gray-400 dark:bg-gray-600 text-white font-medium cursor-not-allowed">
            No Active Salary
        </button>
    @endif
</div>


            {{-- Payment History --}}
            <div class="mt-4">
                <button wire:click="selectTeacher({{ $teacher->id }})"
                        class="text-sm text-purple-600 dark:text-purple-400 font-medium">
                    {{ $selectedTeacher === $teacher->id ? 'Hide' : 'View' }} Payment History
                </button>

                @if($selectedTeacher === $teacher->id)
                    <div class="mt-3 max-h-40 overflow-y-auto border-t border-gray-200 dark:border-gray-700 pt-2 space-y-2">
                        @forelse($teacher->payments as $payment)
                            <div class="p-2 rounded-lg bg-gray-50 dark:bg-gray-700 text-sm">
                                <div class="flex justify-between">
                                    <span class="font-medium text-gray-900 dark:text-gray-100">
                                        ₦{{ number_format($payment->amount, 2) }}
                                    </span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $payment->month }} / {{ $payment->year_id }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-400">
                                    {{ $payment->description ?? 'No description' }}
                                </p>
                                <p class="text-xs {{ $payment->status === 'paid' ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                    Status: {{ ucfirst($payment->status) }}
                                </p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 dark:text-gray-400">No payments yet.</p>
                        @endforelse
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>


    <div>
        {{ $teachers->links() }}
    </div>
</div>

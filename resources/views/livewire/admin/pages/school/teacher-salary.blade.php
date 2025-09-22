<div class="max-w-4xl mx-auto p-4 space-y-6">

    {{-- Search Bar --}}
    <div class="flex items-center gap-2">
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search teacher..." class="w-full rounded-lg border-gray-300 py-2 px-3
                      dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100
                      focus:ring-2 focus:ring-purple-500 focus:border-purple-500" />
    </div>
    <x-admin.message-component class="w-full" />
    <div class="w-full flex items-center justify-end">
        <button wire:click='openSalaryIncreaseModal' class="py-1 px-4 m-2 hover:bg-purple-500 bg-purple-600 text-pretty cursor-pointer rounded-md text-white">Increase Salary</button>
         <button wire:click='downloadTeacherSalariePDF' class="py-1 px-4 m-2 hover:bg-purple-500 bg-purple-600 text-pretty cursor-pointer rounded-md text-white"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m-6 3.75 3 3m0 0 3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
</svg>
 </button>
    </div>
    {{-- Teacher List --}}
    @if($teachers->count())
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($teachers as $teacher)
        <div class="p-4 rounded-2xl shadow-md bg-white dark:bg-gray-800
                            hover:bg-purple-50 dark:hover:bg-gray-700
                            transition-all duration-200 cursor-pointer flex flex-col items-center text-center">

            {{-- Avatar --}}
            <div class="w-16 h-16 rounded-full bg-purple-600 flex items-center justify-center
                                text-white font-bold text-lg shadow-md mb-3">
                {{ strtoupper(substr($teacher->first_name, 0, 1)) }}{{ strtoupper(substr($teacher->last_name, 0, 1)) }}
            </div>

            {{-- Info --}}
            <div class="flex-1">
                <p class="font-semibold text-lg text-gray-900 dark:text-gray-100">
                    {{ $teacher->last_name }} {{ $teacher->first_name }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Sex: <span class="font-medium text-gray-900 dark:text-gray-100">{{ $teacher->sex }}</span>
                </p>
            </div>

            {{-- Salary placeholder --}}
            {{-- Salary --}}
            <div class="mt-3">
                <span class="inline-block px-3 py-1 rounded-full
                 bg-purple-100 dark:bg-purple-900
                 text-purple-700 dark:text-purple-300 text-sm font-medium">
                    ₦ {{ number_format($teacher->activeSalary->amount ?? 0, 2) }}
                </span>
            </div>
            {{-- Salary History --}}
            @if($teacher->salaries->count())
            <div class="mt-4 w-full text-left">
                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Salary History</p>
                <ul class="space-y-1 max-h-32 overflow-y-auto pr-1">
                    @foreach($teacher->salaries->sortByDesc('created_at') as $salary)
                    <li class="text-xs flex justify-between
                           text-gray-600 dark:text-gray-400
                           border-b border-gray-200 dark:border-gray-700 pb-1">
                        <span>
                            ₦ {{ number_format($salary->amount, 2) }}
                        </span>
                        <span class="text-gray-500 dark:text-gray-400">
                            {{ optional($salary->created_at)->format('M Y') }}
                            @if($salary->active)
                            <span class="ml-1 text-green-600 dark:text-green-400 font-medium">(Active)</span>
                            @endif
                        </span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
            {{-- Flash message after update --}}

            @if (session()->has('status') && $updatedTeacherId === $teacher->id)
            <span class="px-4 py-2 text-green-500 text-sm font-medium">
                ✅ {{ session('status') }}
            </span>
            @endif


            {{-- Action Button --}}
            <div class="mt-3">
                <button 
                    wire:click="edit({{ $teacher->id }})" class="px-3 py-1 rounded-lg bg-purple-600 text-white text-sm font-medium
                                       hover:bg-purple-700 focus:ring-2 focus:ring-purple-500">
                    Edit Salary
                </button>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $teachers->links() }}
    </div>
    @else
    <p class="text-center text-gray-600 dark:text-gray-400">
        No teachers found.
    </p>
    @endif

    <!-- Teacher Salary Update Modal -->
   <x-modal name="editSalary" :show="$teacher_id !== null" maxWidth="xl" focusable>
    <div class="p-6">
        <div class="flex justify-between items-center border-b pb-3">
            <h2 class="text-lg font-bold">Update Teacher's Salary</h2>
        </div>

        <form wire:confirm.prompt="Are you sure?\n\nType UPDATE to confirm|UPDATE" wire:submit.prevent="updateTeacher" class="mt-4 flex flex-col space-y-4">
            <!-- Salary -->
            <div>
                <x-input-label for="amount" :value="__('Salary')" />
                <input type="text" wire:model.defer="amount"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                <x-input-error :messages="$errors->get('amount')" />
            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-end items-center space-x-2">
                <button type="button" wire:click="closeModal"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md">Cancel</button>
                <button  type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md"
                    wire:loading.attr="disabled">Update</button>
                <div class="px-4 py-2 text-indigo-700" wire:loading>Updating...</div>
            </div>
        </form>
    </div>
</x-modal>

    <x-modal name="increaseSalary" maxWidth="xl" focusable>
    <div class="p-6">
        <div class="flex justify-between items-center border-b pb-3">
            <h2 class="text-lg font-bold">Increase All Teachers Salary</h2>
        </div>

        <form wire:confirm.prompt="Are you sure?\n\nType UPDATE to confirm|UPDATE" wire:submit.prevent="increaseSalaryForm" class="mt-4 flex flex-col space-y-4">
            <!-- Select Increase Type -->
            <div>
                <x-input-label for="type" :value="__('Type')" />
                <select wire:model.live="selectedType"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                    <option value="">-- Select Type --</option>
                    <option value="amount">Amount</option>
                    <option value="percentage">Percentage</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('selectedType')" />
            </div>

            @if($byAmount)
                <div>
                    <x-input-label for="amountToIncreaseWith" :value="__('Amount')" />
                    <input type="text" wire:model.defer="amountToIncreaseWith"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error :messages="$errors->get('amountToIncreaseWith')" />
                </div>
            @elseif($byPercentage)
                <div>
                    <x-input-label for="selectedPercentage" :value="__('Percentage')" />
                    <select wire:model.live="selectedPercentage"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                        <option value="">-- Select Percentage --</option>
                        @for ($i=1; $i < 101; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('selectedPercentage')" />
                </div>
            @endif

            <!-- Actions -->
            <div class="mt-6 flex justify-end items-center space-x-2">
                <button type="button" wire:click="closeIncreaseSalaryModal"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md">Cancel</button>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md"
                    wire:loading.attr="disabled">Update</button>
                <div class="px-4 py-2 text-indigo-700" wire:loading>Updating...</div>
            </div>
        </form>
    </div>
</x-modal>


</div>

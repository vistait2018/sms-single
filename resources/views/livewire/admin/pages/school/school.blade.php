<div class="p-6 bg-gray-300 dark:bg-gray-600 min-h-screen">
    <!--Messages-->
    <x-admin.message-component class="w-full" />

    @if ($school)
    <div
        class="max-w-4xl mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden md:flex md:items-center">

        <!-- School Logo Section -->
        <div class="md:flex-shrink-0 p-6 flex flex-col justify-center items-center bg-gray-50 dark:bg-gray-700 md:w-1/3">
            @if($showEdit)
            <form wire:submit.prevent="updateLogo" class="flex flex-col items-center space-y-3">
                <input type="file" wire:model="newLogo" class="text-sm text-gray-600 dark:text-gray-200">
                @error('newLogo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-md">
                    Save Logo
                </button>
                <button type="button" wire:click="$set('showEdit', false)"
                    class="text-sm text-gray-500 dark:text-gray-300 underline">
                    Cancel
                </button>
            </form>
            @else
            <img wire:click="$set('showEdit', true)"
                class="h-32 w-32 object-contain rounded-full border-4 border-gray-200 dark:border-gray-600 shadow-md cursor-pointer hover:opacity-80 transition"
                src="{{ $school->school_logo ? asset('storage/'.$school->school_logo) : 'https://via.placeholder.com/150' }}"
                alt="{{ $school->school_name }} Logo">
            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">(Click logo to change)</p>
            @endif
        </div>

        <!-- School Details Section -->
        <div class="p-8 md:w-2/3">
            <div class="tracking-wide text-sm text-purple-600 dark:text-purple-400 font-semibold">School Information</div>
            <h1 class="block uppercase mt-1 text-2xl leading-tight font-extrabold text-gray-900 dark:text-white">
                {{ ucwords($school->school_name) }}
            </h1>
            <p class="mt-4 text-gray-600 dark:text-gray-300">
                Welcome to the admin panel for
                <span class="text-green-900 dark:text-green-500 font-extrabold">{{ ucwords($school->school_name) }}</span>.
                Here you can manage various aspects of your school.
            </p>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6 text-gray-700 dark:text-gray-200">
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Address</p>
                    <p class="mt-1 text-base">{{ $school->address }}, {{ $school->city }}, {{ $school->state }} {{ $school->zip_code }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</p>
                    <a href="mailto:{{ $school->email ?: '#' }}"
                        class="mt-1 text-base text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                        {{ $school->email ?: '--' }}
                    </a>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Phone</p>
                    <p class="mt-1 text-base text-purple-600 dark:text-purple-400">
                        {{ $school->phone_no ?: '--' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Alt Phone</p>
                    <p class="mt-1 text-base text-purple-600 dark:text-purple-400">
                        {{ $school->phone_no2 ?: '--' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Date Of Establishment</p>
                    <p class="mt-1 text-base text-purple-600 dark:text-purple-400">
                        {{ $school->date_of_establishment ?: '--' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Type</p>
                    <p class="mt-1 text-base text-purple-600 dark:text-purple-400">
                        {{ $school->type ?: '--' }}
                    </p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Proprietor</p>
                    <p class="mt-1 text-base text-purple-600 dark:text-purple-400">
                        {{ $school->proprietor ?: '--' }}
                    </p>
                </div>
            </div>

            <div class="mt-8">
                <button x-on:click="$dispatch('open-modal', 'editSchool')"
                    class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                    Edit School Details
                </button>
            </div>
        </div>
    </div>
    @else
    <div
        class="max-w-md mx-auto bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 text-center text-gray-600 dark:text-gray-300">
        <p>No school information available for this user.</p>
        <p class="mt-4 text-sm">Please contact your administrator if you believe this is an error.</p>
    </div>
    @endif

    <!-- Edit School Modal-->
    <x-modal name="editSchool" :show="false" maxWidth="xl">
        <div class="p-6">
            <h2 class="text-lg font-bold">Edit School</h2>

            <form wire:submit.prevent="updateSchool" wire:confirm.prompt="Are you sure you want to update school information?\n\nType SAVE to confirm|SAVE"
                class="mt-4 space-y-4">
                <!-- School Name -->
                <x-input-label for="school_name" :value="__('School Name')" />
                <input type="text" wire:model.defer="school_name"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                <x-input-error class="mt-2" :messages="$errors->get('school_name')" />

                <!-- Address -->
                <x-input-label for="address" :value="__('School Address')" />
                <input type="text" wire:model.defer="address"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                <x-input-error class="mt-2" :messages="$errors->get('address')" />

                <!-- Email -->
                <x-input-label for="email" :value="__('School Email')" />
                <input type="text" wire:model.defer="email"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                <!-- Phone -->
                <x-input-label for="phone_no" :value="__('Phone No')" />
                <input type="text" wire:model.defer="phone_no"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                <x-input-error class="mt-2" :messages="$errors->get('phone_no')" />

                <!-- Date -->
                <x-input-label for="date_of_establishment" :value="__('Date of Establishment')" />
                <input type="date" wire:model.defer="date_of_establishment"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                <x-input-error class="mt-2" :messages="$errors->get('date_of_establishment')" />

                <!-- Proprietor -->
                <x-input-label for="proprietor" :value="__('School Proprietor')" />
                <input type="text" wire:model.defer="proprietor"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                <x-input-error class="mt-2" :messages="$errors->get('proprietor')" />

                <!-- Type -->
                <x-input-label for="type" :value="__('Type')" />
                <select wire:model.defer="type"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                    <option value="" selected>-- Select Type --</option>
                    <option value="primary">Primary</option>
                    <option value="secondary">Secondary</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('type')" />

                <!-- Actions -->
                <div class="mt-6 flex justify-end items-center space-x-2">
                    <button type="button" x-on:click="$dispatch('close-modal', 'editSchool')"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md">Cancel</button>

                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md"
                        wire:loading.attr="disabled">Save</button>

                    <div class="px-4 py-2 text-purple-700" wire:loading>Saving...</div>

                    @if (session()->has('status'))
                    <span class="px-4 py-2 text-green-500 text-sm font-medium">
                        ✅ {{ session('status') }}
                    </span>
                    @endif
                </div>
            </form>
        </div>
    </x-modal>
</div>

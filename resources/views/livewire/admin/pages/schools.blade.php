<div class="p-6">

    <div class="flex justify-end items-center mb-4 ">
        <button x-on:click="$dispatch('open-modal', 'addSchool')"
            class=" flex px-4 py-2  bg-purple-600 text-white rounded-md hover:bg-purple-300 transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>

        </button>
    </div>
    {{-- Search --}}
    <div class="mb-6 grid  gap-4">
        <input type="text" wire:model.live.debounce.500ms="search" placeholder="Search schools by name ,email,type..."
            class="w-full md:w-full px-4 py-2 border rounded-lg text-gray-500 shadow-sm focus:outline-none focus:ring focus:ring-indigo-500">
    </div>

    <!--Mesages-->
    <x-admin.message-component class="w-full" />

    {{-- Grid of cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($schools as $school)
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow p-4 flex flex-col items-center text-center">

            {{-- Avatar (school_logo) --}}
            <div class="w-24 h-24 mb-6 relative">
                @if($school->school_logo)
                <img wire:click="showLogoEditor({{ $school->id }})" src="{{ asset('storage/' . $school->school_logo) }}"
                    alt="{{ $school->school_name }}" class="w-full h-full rounded-full object-cover border">
                @else
                <div wire:click="showLogoEditor({{ $school->id }})"
                    class="w-full h-full flex items-center justify-center bg-gray-200 rounded-full">
                    <span class="text-gray-500 text-sm">No Logo</span>
                </div>
                @endif

                {{-- Upload Button --}}
                @if($editLogo && $editingSchoolId === $school->id)
                <div class="mt-3 mb-10">
                    <input type="file" wire:model="logo" class="block text-sm text-gray-500" />

                    <button wire:click="updateLogo({{ $school->id }})" wire:loading.attr="disabled"
                        class="mt-2 px-3 py-1 bg-indigo-600 text-white text-xs rounded">
                        Update Logo
                    </button>

                    {{-- Progress/Error --}}
                    @error('logo') <span class="text-red-500 text-xs mb-5">{{ $message }}</span> @enderror
                    <div wire:loading wire:target="logo" class="text-xs text-gray-500 mt-1">Uploading...</div>
                </div>
                @endif
            </div>
            {{-- School Info --}}
            <div class="mt-3">
                <div class="flex items-center justify-center gap-3">
                    <h3 class="text-lg font-semibold">{{ $school->school_name }}</h3>
                    <svg wire:click="showeditForm({{ $school->id }})" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="size-6 text-purple-500 hover:text-purple-300">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                </div>
                <p class="text-sm text-gray-500">{{ $school->type }}</p>
                <p class="text-sm text-gray-500">{{ $school->email }}</p>
                <p class="text-sm text-gray-500">{{ $school->phone_no }} </p>
                <p class="text-sm text-gray-500">{{ $school->address }}</p>
                <p class="text-xs text-gray-400">Established: {{ $school->date_of_establishment  }}</p>
                <p class="text-xs text-gray-400">Proprietor: {{ $school->proprietor }}</p>
            </div>
            {{-- Status --}}
            <div class="mt-3">
                @if($school->is_locked)
                <svg wire:confirm.prompt="Are you sure?\n\nType UNLOCK to confirm|UNLOCK"
                    wire:click="unlockSchool({{ $school->id }})" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-red-500">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>

                @else
                <svg wire:confirm.prompt="Are you sure?\n\nType LOCK to confirm|LOCK"
                    wire:click="lockSchool({{ $school->id }})" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-green-500">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13.5 10.5V6.75a4.5 4.5 0 1 1 9 0v3.75M3.75 21.75h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H3.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                </svg>

                @endif
            </div>


        </div>
        @empty
        <div class="col-span-3 text-center text-gray-500">
            No schools found.
        </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $schools->links() }}
    </div>

    <!-- School Modal-->
    <!-- Edit School Modal-->
    <x-modal name="editSchool" :show="false" maxWidth="xl">
        <div class="p-6">
            <h2 class="text-lg font-bold">Edit School</h2>

            <form wire:submit.prevent="updateSchool" wire:confirm.prompt="Are you sure?\n\nType SAVE to confirm|SAVE"
                class="mt-4 space-y-4">

                <!-- School Name -->
                <div>
                    <x-input-label for="school_name" :value="__('School Name')" />
                    <input type="text" wire:model.defer="school_name"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error class="mt-2" :messages="$errors->get('school_name')" />
                </div>

                <!-- Address -->
                <div>
                    <x-input-label for="address" :value="__('School Address')" />
                    <input type="text" wire:model.defer="address"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>

                <!-- Email-->
                <div>
                    <x-input-label for="email" :value="__('School Email')" />
                    <input type="text" wire:model.defer="email"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
                <!-- Phone Number -->
                <div>
                    <x-input-label for="phone_no" :value="__('Phone No')" />
                    <input type="text" wire:model.defer="phone_no"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error class="mt-2" :messages="$errors->get('phone_no')" />
                </div>

                <!-- Date of Establishment -->
                <div>
                   
                    <x-input-label for="date_of_establishment" :value="__('Date of Establishment')" />
                    <input type="date" wire:model.defer="date_of_establishment"
                      value="{{ \Carbon\Carbon::parse($school->date_of_establishment)->format('Y-m-d') }}"  class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error class="mt-2" :messages="$errors->get('date_of_establishment')" />
                </div>


                <!-- Proprietor -->
                <div>
                    <x-input-label for="proprietor" :value="__('School Proprietor')" />
                    <input type="text" wire:model.defer="proprietor"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error class="mt-2" :messages="$errors->get('proprietor')" />
                </div>

                <!-- Type -->
                <div>
                    <x-input-label for="type" :value="__('Type')" />
                    <select wire:model.defer="type"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                        <option value="" selected>-- Select Type --</option>
                        <option value="primary">Primary</option>
                        <option value="secondary">Secondary</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('type')" />
                </div>

                <!-- Actions -->
                <div class="mt-6 flex justify-end items-center space-x-2">
                    <button type="button" x-on:click="$dispatch('close-modal', 'editSchool')"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md">
                        Cancel
                    </button>

                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md"
                        wire:loading.attr="disabled">
                        Save
                    </button>

                    <!-- Loading -->
                    <div class="px-4 py-2 text-purple-700" wire:loading>
                        Saving...
                    </div>

                    <!-- Success (controlled via Livewire flash or Alpine) -->
                    @if (session()->has('success'))
                    <span class="px-4 py-2 text-green-500 text-sm font-medium">
                        ✅ {{ session('success') }}
                    </span>
                    @endif
                </div>
            </form>
        </div>
    </x-modal>
    <!-- Add New School Modal-->
    <x-modal name="addSchool" :show="false" maxWidth="xl">
        <div class="p-6">
            <h2 class="text-lg font-bold">Add School</h2>

            <form
                {{-- wire:confirm.prompt="Are you sure?\n\nType SAVE to confirm|SAVE" --}}
                class="mt-4 flex flex-col space-y-4">

                <!-- School Name & Address -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <x-input-label for="school_name" :value="__('School Name')" />
                        <input type="text" wire:model.defer="school_name"
                            class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2"/>
                        <x-input-error class="mt-2" :messages="$errors->get('school_name')" />
                    </div>

                    <div class="flex-1">
                        <x-input-label for="address" :value="__('School Address')" />
                        <input type="text" wire:model.defer="address"
                            class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                        <x-input-error class="mt-2" :messages="$errors->get('address')" />
                    </div>
                </div>

                <!-- Email & Phone -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <x-input-label for="email" :value="__('School Email')" />
                        <input type="email" wire:model.defer="email"
                            class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2"/>
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="flex-1">
                        <x-input-label for="phone_no" :value="__('Phone No')" />
                        <input type="text" wire:model.defer="phone_no"
                            class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2"/>
                        <x-input-error class="mt-2" :messages="$errors->get('phone_no')" />
                    </div>
                </div>

                <!-- Date of Establishment & Proprietor -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <x-input-label for="date_of_establishment" :value="__('Date of Establishment')" />
                        <input type="date" wire:model.defer="date_of_establishment"
                            class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2"/>
                        <x-input-error class="mt-2" :messages="$errors->get('date_of_establishment')" />
                    </div>

                    <div class="flex-1">
                        <x-input-label for="proprietor" :value="__('School Proprietor')" />
                        <input type="text" wire:model.defer="proprietor"
                            class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2"/>
                        <x-input-error class="mt-2" :messages="$errors->get('proprietor')" />
                    </div>
                </div>

                <!-- Type -->
                <div>
                    <x-input-label for="type" :value="__('Type')" />
                    <select wire:model.defer="type"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                        <option value="" selected>-- Select Type --</option>
                        <option value="primary">Primary</option>
                        <option value="secondary">Secondary</option>
                    </select>
                    <x-input-error class="mt-2" :messages="$errors->get('type')" />
                </div>
            </form>

            <!-- Separator -->
            <hr class="my-6 border-gray-300 dark:border-gray-600">

            <!-- School Admin Section -->
            <h3 class="text-md font-semibold mb-4">School Admin Information</h3>

            <div class="flex flex-col space-y-4">
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <x-input-label for="first_name" :value="__('First Name')" />
                        <input type="text" wire:model.defer="first_name"
                            class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2"/>
                        <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                    </div>

                    <div class="flex-1">
                        <x-input-label for="last_name" :value="__('Last Name')" />
                        <input type="text" wire:model.defer="last_name"
                            class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2"/>
                        <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="flex-1">
                        <x-input-label for="sex" :value="__('Sex')" />
                        <select wire:model.defer="sex"
                            class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                            <option value="" selected>-- Select --</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('sex')" />
                    </div>

                    <div class="flex-1">
                        <x-input-label for="admin_email" :value="__('Admin Email')" />
                        <input type="email" wire:model.defer="admin_email"
                            class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2"/>
                        <x-input-error class="mt-2" :messages="$errors->get('admin_email')" />
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="mt-6 flex justify-end items-center space-x-2">
                <button type="button" x-on:click="$dispatch('close-modal', 'addSchool')"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md">
                    Cancel
                </button>

                <button  type="button" wire:click='addSchool' class="px-4 py-2 bg-purple-600 text-white rounded-md"
                    wire:loading.attr="disabled">
                    Save
                </button>

                <div class="px-4 py-2 text-purple-700" wire:loading>
                    Saving...
                </div>

                @if (session()->has('success'))
                    <span class="px-4 py-2 text-green-500 text-sm font-medium">
                        ✅ {{ session('success') }}
                    </span>
                @endif
            </div>
        </div>
    </x-modal>



</div>

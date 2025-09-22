<div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8 space-y-8">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Student Registration</h1>

        <button wire:click="toggleStudentform"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-xl shadow transition">
            {{ $showStudentForm ? 'View Students' : 'Register New Student' }}
        </button>
    </div>
    <!--Mesages-->
    <x-admin.message-component class="w-full" />

    <!-- Form -->
    @if($showStudentForm)
    {{-- Registration Form --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 space-y-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Register Student</h2>

        <form wire:submit.prevent="registerStudent" class="space-y-5">
            <!-- Avatar -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Avatar</label>
                <input type="file" wire:model="avatar" class="mt-1 block w-full text-sm text-gray-700 dark:text-gray-300
                               file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0
                               file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700
                               hover:file:bg-indigo-100" />
                @error('avatar') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

                {{-- Preview when selected --}}
                @if ($avatar)
                <div class="mt-3">
                    <span class="text-xs text-gray-500">Preview:</span>
                    <img src="{{ $avatar->temporaryUrl() }}" class="w-20 h-20 rounded-full object-cover mt-1">
                </div>
                @endif
            </div>
            <!-- First Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">First Name *</label>
                <input type="text" wire:model.defer="first_name"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2"
                    placeholder="Enter first name">
                @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Middle Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Middle Name</label>
                <input type="text" wire:model.defer="middle_name"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2"
                    placeholder="Enter middle name">
            </div>

            <!-- Last Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name *</label>
                <input type="text" wire:model.defer="last_name"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2"
                    placeholder="Enter last name">
                @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Sex -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sex *</label>
                <select wire:model.defer="sex"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                    <option value="" >-- Select Sex--</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                @error('sex') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Level -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Class *</label>
                <select wire:model.defer="selectLevel"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                    <option value="" >-- Select Class --</option>
                    @foreach($levels as $level)
                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                    @endforeach
                </select>

               
                @error('selectLevel')
                <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <!-- Phone -->
            <div>
                <x-input-label for="phone_no" :value="__('Phone Number')" />
                <input type="text" wire:model.defer="phone_no"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                <x-input-error :messages="$errors->get('phone_no')" />
            </div>

            <!-- Address -->
            <div class="col-span-2">
                <x-input-label for="address" :value="__('Address')" />
                <textarea wire:model.defer="address"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2"></textarea>
                <x-input-error :messages="$errors->get('address')" />
            </div>

            <!-- Date of Birth -->
            <div>
                <x-input-label for="dob" :value="__('Date of Birth')" />
                <input type="date" wire:model.defer="dob"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                <x-input-error :messages="$errors->get('dob')" />
            </div>

            <!-- Religion -->
            <div>
                <x-input-label for="selectedReligion" :value="__('Religion')" />
                <select wire:model.live="selectedReligion"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                    <option value="" >-- Select --</option>
                    <option value="christianity">Christianity</option>
                    <option value="islam">Islam</option>
                    <option value="others">Others</option>
                </select>
                <x-input-error :messages="$errors->get('selectedReligion')" />
            </div>

            <!-- Nationality -->
            {{-- <div>
                <x-input-label for="nationality" :value="__('Nationality')" />
                <input type="text" wire:model.defer="nationality"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                <x-input-error :messages="$errors->get('nationality')" />
            </div> --}}

            <!-- State -->
            <div>
                <label class="block font-medium">State</label>
                <select wire:model.live="selectedState"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                    <option value="">-- Select State --</option>
                    @foreach ($states as $state)
                    <option value="{{ $state->id }}">{{ $state->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- LGA -->
            <div>
                <label class="block font-medium">LGA</label>
                <select wire:model.live="selectedLga"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                    <option value="">-- Select LGA --</option>
                    @forelse ($lgas as $lga)
                    <option value="{{ $lga->id }}">{{ $lga->name }}</option>
                    @empty
                    <option>No LGAs found</option>
                    @endforelse
                </select>
            </div>




            <!-- Submit -->
            <div class="pt-4">
                <button type="submit"
                    class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-xl shadow transition">
                    Register Student
                </button>
            </div>
        </form>

        <x-action-message on="saved"> ✅ Student registered successfully! </x-action-message>
    </div>
    @else
    <!-- Student List -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 space-y-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Students</h2>

        <!-- Search -->
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name or sex..."
            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 text-sm p-2">

        <!-- Cards -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($students as $student)
            <div
                class="p-4 rounded-xl bg-gray-50 dark:bg-gray-700 shadow cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                <!-- Activate User-->
                <div class="flex justify-end mb-2 items-center   cursor-pointer">
                    <svg wire:click="viewStudent({{ $student->id }})" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="size-4 text-green-500 hover:text-green-400">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                   @php
                       //dd($student->user?->is_activated   === 0);
                   @endphp
               @if(!($student->user?->is_activated))
                    <svg wire:click="addUser({{ $student->id }})" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="size-4 hover:text-purple-400 text-purple-500">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                    @else
                    <svg wire:click="removeUser({{ $student->id }})" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4 hover:text-red-400 text-red-500">
             <path stroke-linecap=" round" stroke-linejoin="round"
                        d="M22 10.5h-6m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM4 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 10.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                    @endif
                   


                </div>
                <!-- Avatar -->
                <div class="flex justify-center mb-3" wire:click.stop>
                    <label for="avatar-{{ $student->id }}" class="relative cursor-pointer">
                        <img src="{{ $student->avatar ? asset('storage/' . $student->avatar)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($student->first_name . ' ' . $student->last_name) . '&background=random' }}"
                            alt="Student Avatar"
                            class="w-20 h-20 rounded-full object-cover border-2 border-indigo-500 hover:opacity-80 transition">

                        <!-- Hidden File Input -->
                        <input type="file" id="avatar-{{ $student->id }}" class="hidden"
                            wire:model="avatars.{{ $student->id }}" accept="image/*">

                        <!-- Small overlay edit icon -->
                        <span
                            class="absolute bottom-0 right-0 bg-indigo-600 text-white text-xs px-1.5 py-0.5 rounded-full">
                            ✏️
                        </span>
                    </label>
                </div>

                <!-- Student Info -->
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 text-center">
                    {{ $student->first_name }} {{ $student->last_name }}
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 text-center">
                    Sex: {{ ucfirst($student->sex) }}
                </p>

                <p class="text-sm text-gray-600 dark:text-gray-300 text-center">
                    Class: {{ ucfirst($student->levels()?->first()->name??'---') }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-300 text-center">
                    DOB: {{$student->dob ? \Carbon\Carbon::parse($student->dob)->format('d M, Y') : '---' }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-300 text-center">
                    LIN NO: {{$student->lin_no ?? '---' }}
                </p>
            </div>
            @empty
            <p class="text-sm text-gray-500 dark:text-gray-400">No students found.</p>
            @endforelse
        </div>
        <!-- Pagination links -->
        <div class="mt-4">
            {{ $students->links() }}
        </div>
    </div>
    @endif

    <!-- Student Update Modal -->
    <x-modal name="editStudent" :show="$selectedStudent !== null" maxWidth="xl" focusable>
        <div class="p-6">
            <div class="flex justify-between items-center border-b pb-3">
                <h2 class="text-lg font-bold">Update Student</h2>

                <!-- Toggle Button -->
                <button type="button" wire:click="$toggle('edit')"
                    class="px-3 py-1 rounded-md text-sm font-medium transition {{ $edit ? 'bg-gray-500 text-white' : 'bg-indigo-600 text-white' }}">
                    {{ $edit ? 'Cancel ❌' : 'Enable Edit ✏️' }}
                </button>
            </div>

            {{-- VIEW MODE --}}
            @if(!$edit)
            <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                <div><span class="font-semibold">First Name:</span> {{ $first_name }}</div>
                <div><span class="font-semibold">Middle Name:</span> {{ $middle_name }}</div>
                <div><span class="font-semibold">Last Name:</span> {{ $last_name }}</div>
                <div><span class="font-semibold">Sex:</span> {{ ucfirst($sex) }}</div>
                <div><span class="font-semibold">Class:</span> {{ ucfirst($level) }}</div>
                <div><span class="font-semibold">Lin No:</span> {{ $lin_no ?? '---' }}</div>
                <div><span class="font-semibold">Phone:</span> {{ $phone_no }}</div>
                <div class="col-span-2"><span class="font-semibold">Address:</span> {{ $address }}</div>
                <div><span class="font-semibold">Date of Birth:</span> {{ $dob }}</div>
                <div><span class="font-semibold">Religion:</span> {{ $religion }}</div>
                <div><span class="font-semibold">Nationality:</span> {{ $nationality }}</div>
                <div><span class="font-semibold">State of Origin:</span> {{ $state_of_origin }}</div>
            </div>

            <div class="col-span-2 mt-6 flex justify-end items-center space-x-2">
                <button type="button" wire:click="closeStudentModal"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md">
                    Close
                </button>
            </div>
            @else
            {{-- EDIT MODE --}}
            <form wire:submit.prevent="updateStudent" class="mt-4 space-y-4 grid grid-cols-2 gap-4">
                <!-- First Name -->
                <div>
                    <x-input-label for="first_name" :value="__('First Name')" />
                    <input type="text" wire:model.defer="first_name"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error :messages="$errors->get('first_name')" />
                </div>

                <!-- Middle Name -->
                <div>
                    <x-input-label for="middle_name" :value="__('Middle Name')" />
                    <input type="text" wire:model.defer="middle_name"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error :messages="$errors->get('middle_name')" />
                </div>

                <!-- Last Name -->
                <div>
                    <x-input-label for="last_name" :value="__('Last Name')" />
                    <input type="text" wire:model.defer="last_name"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error :messages="$errors->get('last_name')" />
                </div>

                <!-- Sex -->
                <div>
                    <x-input-label for="sex" :value="__('Sex')" />
                    <select wire:model.defer="sex"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                        <option value="" disabled>-- Select --</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                    <x-input-error :messages="$errors->get('sex')" />
                </div>

                <!-- Phone -->
                <div>
                    <x-input-label for="phone_no" :value="__('Phone Number')" />
                    <input type="text" wire:model.defer="phone_no"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error :messages="$errors->get('phone_no')" />
                </div>

                <!-- Address -->
                <div class="col-span-2">
                    <x-input-label for="address" :value="__('Address')" />
                    <textarea wire:model.defer="address"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2"></textarea>
                    <x-input-error :messages="$errors->get('address')" />
                </div>

                <!-- Date of Birth -->
                <div>
                    <x-input-label for="dob" :value="__('Date of Birth')" />
                    <input type="date" wire:model.defer="dob"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error :messages="$errors->get('dob')" />
                </div>

                <!-- Religion -->
                <div>
                    <x-input-label for="selectedReligion" :value="__('Religion')" />
                    <select wire:model.live="selectedReligion"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                        <option value="" selected disabled>-- Select --</option>
                        <option value="christianity">Christianity</option>
                        <option value="islam">Islam</option>
                        <option value="others">Others</option>
                    </select>
                    <x-input-error :messages="$errors->get('selectedReligion')" />
                </div>

                <!-- Nationality -->
                {{-- <div>
                    <x-input-label for="nationality" :value="__('Nationality')" />
                    <input type="text" wire:model.defer="nationality"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error :messages="$errors->get('nationality')" />
                </div> --}}

                <!-- State -->
                <div>
                    <label class="block font-medium">State</label>
                    <select wire:model.live="selectedState"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                        <option value="">-- Select State --</option>
                        @foreach ($states as $state)
                        <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- LGA -->
                <div>
                    <label class="block font-medium">LGA</label>
                    <select wire:model.live="selectedLga"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                        <option value="">-- Select LGA --</option>
                        @forelse ($lgas as $lga)
                        <option value="{{ $lga->id }}">{{ $lga->name }}</option>
                        @empty
                        <option>No LGAs found</option>
                        @endforelse
                    </select>
                </div>


                <!-- Actions -->
                <div class="col-span-2 mt-6 flex justify-end items-center space-x-2">
                    <button type="button" wire:click="closeStudentModal"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md"
                        wire:loading.attr="disabled">Update</button>
                    <div class="px-4 py-2 text-indigo-700" wire:loading>Updating...</div>
                    @if (session()->has('success'))
                    <span class="px-4 py-2 text-green-500 text-sm font-medium">
                        ✅ {{ session('success') }}
                    </span>
                    @endif
                </div>
            </form>
            @endif
        </div>
    </x-modal>


     <x-modal name="addUser" maxWidth="xl" focusable>
    <div class="p-6">
        <div class="flex justify-between items-center border-b pb-3">
            <h2 class="text-lg font-bold">Activate User</h2>
        </div>

        {{-- EDIT MODE --}}
        <form wire:submit.prevent="notifyUser" class="mt-4 w-full gap-4">
            
            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <input type="email" wire:model.defer="email"
                    class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                <x-input-error :messages="$errors->get('email')" />
            </div>

            <!-- Actions -->
            <div class="col-span-2 mt-6 flex justify-end items-center space-x-2">
                <button type="button" 
                        wire:click="closeStudentModal"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md">
                    Cancel
                </button>

                <button type="submit" 
                        class="px-4 py-2 bg-indigo-600 text-white rounded-md"
                        wire:loading.attr="disabled">
                    Update
                </button>

                <div class="px-4 py-2 text-indigo-700" wire:loading>
                    Updating...
                </div>

                @if (session()->has('success'))
                    <span class="px-4 py-2 text-green-500 text-sm font-medium">
                        ✅ {{ session('success') }}
                    </span>
                @endif
            </div>
        </form>
    </div>
</x-modal>



</div>
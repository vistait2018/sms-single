<div class="max-w-4xl mx-auto p-4 sm:p-6 lg:p-8 space-y-8">

    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">Teacher Registration</h1>
        <button wire:click="$toggle('showTeacherForm')"
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-xl shadow transition">
            {{ $showTeacherForm ? 'View Teachers' : 'Register New Teacher' }}
        </button>
    </div>

    <!-- Form -->
    @if($showTeacherForm)
    {{-- Registration Form --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 space-y-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Register Teacher</h2>

        <form wire:submit.prevent="registerTeacher" class="space-y-5">
            <!-- Avatar -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Avatar</label>
                <input type="file" wire:model="avatar" class="mt-1 block w-full text-sm text-gray-700 dark:text-gray-300
               file:mr-4 file:py-2 file:px-4
               file:rounded-xl file:border-0
               file:text-sm file:font-semibold
               file:bg-indigo-50 file:text-indigo-700
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
                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 text-sm"
                    placeholder="Enter first name">
                @error('first_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Middle Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Middle Name</label>
                <input type="text" wire:model.defer="middle_name"
                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 text-sm"
                    placeholder="Enter middle name">
            </div>

            <!-- Last Name -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Last Name *</label>
                <input type="text" wire:model.defer="last_name"
                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 text-sm"
                    placeholder="Enter last name">
                @error('last_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Sex -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sex *</label>
                <select wire:model.defer="sex"
                    class="mt-1 block p-2 w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">-- Select --</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                </select>
                @error('sex') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <!-- Address -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Address *</label>
                <input type="address" wire:model.defer="address"
                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 text-sm"
                    placeholder="Enter Address">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <!-- Email -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email *</label>
                <input type="email" wire:model.defer="email"
                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 text-sm"
                    placeholder="Enter email">
                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <!-- Phone No -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone Number *</label>
                <input type="text" wire:model.defer="phone_no"
                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 text-sm"
                    placeholder="Enter Phone No">
                @error('phone_no') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <!-- Qualification -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Qualification *</label>
                <select
                    class="mt-1 block p-2 w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 text-sm"
                    wire:model.defer="qualification">
                    <option value="">-- Select --</option>
                    <option value="ssce">SSCE</option>
                    <option value="ond">OND</option>
                    <option value="hnd">HND</option>
                    <option value="bsc">BSc</option>
                    <option value="bed">BEd</option>
                </select>
                @error('qualification') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <!-- Qualification Details -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Qualification Details
                    *</label>
                <input type="text" wire:model.defer="details"
                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 text-sm"
                    placeholder="Enter Qualifcation Details">
                @error('details') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <!-- Date of Birth -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of Birth *</label>
                <input type="date" wire:model.defer="dob"
                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 text-sm"
                    placeholder="Enter Date of Birth">
                @error('dob') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <!-- Date of Employement -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date of Employment *</label>
                <input type="date" wire:model.defer="date_of_employement"
                    class="mt-1 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 text-sm"
                    placeholder="Enter Date of Employement">
                @error('date_of_employement') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            <!-- State -->
            <div>
                <label class="block font-medium">State</label>
                <select wire:model.live="selectedState"
                    class="mt-1 p-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 text-sm">
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
                    class="mt-1 p-2 block w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 text-sm">
                    <option value="">-- Select LGA --</option>
                    @foreach ($lgas as $lga)
                    <option value="{{ $lga->id }}">{{ $lga->name }}</option>

                    @endforeach
                </select>
            </div>
            <!-- Religion -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Religion *</label>
                <select
                    class="mt-1 block p-2 w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 text-sm"
                    wire:model.defer="religion">
                    <option value="">-- Select --</option>
                    <option value="christianity">Christianity</option>
                    <option value="islam">Islam</option>
                    <option value="others">Others</option>
                </select>
                @error('sex') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>





            <!-- Submit -->
            <div class="pt-4">
                <button wire:loading.attr="disabled" type="submit"
                    class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-xl shadow transition">
                    Register Teacher
                </button>
                <div class="px-4 py-2 text-indigo-700" wire:loading>
                    Updating...
                </div>

            </div>
        </form>

        <x-action-message on="saved">
            ✅ Teacher registered successfully!
        </x-action-message>
    </div>
    @else
    <!-- Teacher List -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 space-y-6">
        <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">Teachers</h2>

        <!-- Search -->
        <input type="text" wire:model.live.debounce.300ms="search" placeholder="Search by name or sex..."
            class="w-full rounded-xl border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 text-sm p-2">

        <!-- Cards -->
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($teachers as $teacher)

            <div wire:click="viewTeacher({{ $teacher->id }})"
                class="p-4 rounded-xl bg-gray-50 dark:bg-gray-700 shadow cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600 transition">
                <!-- Avatar -->
                <div class="flex justify-center mb-3" wire:click.stop>
                    <label for="avatar-{{ $teacher->id }}" class="relative cursor-pointer">
                        @php
                        // dd($teacher->user?->avatar );
                        @endphp
                        <img src="{{ $teacher->user?->avatar ? asset('storage/' . $teacher->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($teacher->first_name . ' ' . $teacher->last_name) . '&background=random' }}"
                            alt="Teacher Avatar"
                            class="w-20 h-20 rounded-full object-cover border-2 border-indigo-500 hover:opacity-80 transition">
                        <!-- Hidden File Input -->
                        <input type="file" id="avatar-{{ $teacher->id }}" class="hidden"
                            wire:model="avatars.{{ $teacher->id }}" accept="image/*">
                        <!-- Small overlay edit icon -->
                        <span
                            class="absolute bottom-0 right-0 bg-indigo-600 text-white text-xs px-1.5 py-0.5 rounded-full">
                            ✏️
                        </span>
                    </label>
                </div>


                <!-- Teacher Info -->
                <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-200 text-center">
                    {{ $teacher->first_name }} {{ $teacher->last_name }}
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-300 text-center">
                    Sex: {{ ucfirst($teacher->sex) }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-300 text-center">
                    Email: {{ $teacher->user?->email ?? '-' }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-300 text-center">
                    Class Teacher: {{ $teacher->levels()->where('active',true)->first()?->name ?? '-' }}
                </p>
              <p class="text-sm text-gray-600 dark:text-gray-300 text-center">
    Designation:
    {{ $teacher->user?->hasRole('school-head')
        ? ucwords($teacher->school->school_head_title ?? 'school-head')
        : ucwords($teacher->user?->roles?->pluck('name')->join(', ') ?? 'N/A') }}
</p>

<div class="mt-3 text-center" wire:click.stop>
    <label for="sign-{{ $teacher->id }}" class="cursor-pointer inline-block">
        @if ($teacher->sign_url)
            {{-- <img src="{{ asset('storage/' . $teacher->sign_url) }}"
                 alt="Teacher Signature"
                 class="mx-auto h-16 object-contain border border-gray-300 p-1 rounded mb-2"> --}}
                   <p class="text-xs text-green-600 font-semibold">✅ Signature uploaded</p>
        @else
            <p class="text-xs text-red-500"> ❌ No signature uploaded</p>
        @endif

        <div class="bg-indigo-600 text-white px-3 py-1 rounded text-sm inline-block mt-1 hover:bg-indigo-700 transition">
            Upload Signature
        </div>
    </label>

    <!-- Hidden Input -->
    <input type="file" id="sign-{{ $teacher->id }}" class="hidden"
           wire:model="signatures.{{ $teacher->id }}" accept="image/*">

    @error("signatures.$teacher->id")
        <span class="text-red-500 text-xs">{{ $message }}</span>
    @enderror

    <!-- Loading State -->
    <div wire:loading wire:target="signatures.{{ $teacher->id }}" class="text-xs text-gray-500 mt-1">
        Uploading...
    </div>
</div>

            </div>


            @empty
            <p class="text-sm text-gray-500 dark:text-gray-400">No teachers found.</p>
            @endforelse
        </div>
        <div class="mt-4">
            {{ $teachers->links() }}
        </div>

    </div>
    @endif


    <!-- Modal -->
    <!-- Teacher Update Modal -->
    <x-modal name="editTeacher" :show="$selectedTeacher !== null" maxWidth="xl" focusable>
        <div class="p-6">
            <div class="flex justify-between items-center border-b pb-3">
                <h2 class="text-lg font-bold">Update Teacher</h2>

                <!-- Toggle Button -->
                <button type="button" wire:click="$toggle('edit')"
                    class="px-3 py-1 rounded-md text-sm font-medium transition {{ $edit ? 'bg-gray-500 text-white' : 'bg-indigo-600 text-white' }}">
                    {{ $edit ? 'Cancel ❌' : 'Enable Edit ✏️' }}
                </button>

            </div>

            {{-- VIEW MODE --}}
            @if(!$edit)
            @php


if($selectedTeacher){
   $level = $selectedTeacher->levels()->wherePivot('active',true)->first();
}
@endphp





            @endphp
            <div class="mt-4 grid grid-cols-2 gap-4 text-sm">
                <div><span class="font-semibold">First Name:</span> {{ $first_name }}</div>
                <div><span class="font-semibold">Middle Name:</span> {{ $middle_name }}</div>
                <div><span class="font-semibold">Last Name:</span> {{ $last_name }}</div>
                <div><span class="font-semibold">Sex:</span> {{ ucfirst($sex) }}</div>
                <div><span class="font-semibold">Email:</span> {{ $email }}</div>
                <div><span class="font-semibold">Phone:</span> {{ $phone_no }}</div>
                <div class="col-span-2"><span class="font-semibold">Address:</span> {{ $address }}</div>
                <div><span class="font-semibold">Qualification:</span> {{ $qualification }}</div>
                <div><span class="font-semibold">Date of Employment:</span> {{ $date_of_employment }}</div>
                <div><span class="font-semibold">Date of Birth:</span> {{ $dob }}</div>
                <div>
                    <spa@n class="font-semibold">Religion:</span> {{ $religion }}
                </div>
                <div><span class="font-semibold">Nationality:</span> {{ $nationality }}</div>
                <div><span class="font-semibold">State of Origin:</span> {{ $state_of_origin }}</div>
                <div><span>Class: </span>{{ $level?->name ?? 'Not assigned to class' }}</div>
            </div>

            <div class="col-span-2 mt-6 flex justify-end items-center space-x-2">
                <button type="button" x-on:click="$dispatch('close-modal', 'editTeacher')"
                    class="px-4 py-2 bg-gray-500 text-white rounded-md">
                    Close
                </button>
            </div>
            @else
            {{-- EDIT MODE --}}
            <form wire:submit.prevent="updateTeacher" class="mt-4 space-y-4 grid grid-cols-2 gap-4">

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

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <input type="email" wire:model.defer="email"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error :messages="$errors->get('email')" />
                </div>

                <!-- Phone -->
                <div>
                    <x-input-label for="phone_no" :value="__('Phone Number')" />
                    <input type="text" wire:model.defer="phone_no"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error :messages="$errors->get('phone_no')" />
                </div>

                <!-- Address -->
                <div>
                    <x-input-label for="address" :value="__('Address')" />
                    <textarea wire:model.defer="address"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2"></textarea>
                    <x-input-error :messages="$errors->get('address')" />
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Qualification *</label>
                    <select class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2"
                        wire:model.defer="qualification">
                        <option value="">-- Select --</option>
                        <option value="ssce">SSCE</option>
                        <option value="ond">OND</option>
                        <option value="hnd">HND</option>
                        <option value="bsc">BSc</option>
                        <option value="bed">BEd</option>
                    </select>
                    @error('qualification') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <!-- Date of Employment -->
                <div>
                    <x-input-label for="date_of_employment" :value="__('Date of Employment')" />
                    <input type="date" wire:model.defer="date_of_employment"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error :messages="$errors->get('date_of_employment')" />
                </div>
                <!-- Ddtails -->
                <div>
                    <x-input-label for="details" :value="__('Qualification details')" />
                    <input type="text" wire:model.defer="details"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error :messages="$errors->get('details')" />
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
                    <x-input-label for="religion" :value="__('Religion')" />
                    <input type="text" wire:model.defer="religion"
                        class="mt-1 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                    <x-input-error :messages="$errors->get('religion')" />
                </div>

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
                        @foreach ($lgas as $lga)
                        <option value="{{ $lga->id }}">{{ $lga->name }}</option>

                        @endforeach
                    </select>
                </div>


                <!-- Actions -->
                <button type="button" wire:click="generatePassword"
                    class="ml-2 text-sm text-indigo-600">Generate</button>

                <div class="col-span-2 mt-6 flex justify-end items-center space-x-2">
                    <button type="button" x-on:click="$dispatch('close-modal', 'editTeacher')"
                        class="px-4 py-2 bg-gray-500 text-white rounded-md">
                        Cancel
                    </button>

                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md"
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
            @endif
        </div>
    </x-modal>





</div>

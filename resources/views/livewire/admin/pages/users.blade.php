<div class="p-4">
    <!--Mesages-->
    <x-admin.message-component />
    <!-- 🔝 Header -->

    <x-admin.header :title="'All Schools Users'" :action="'createUser'" />

    <!-- 🔍 Search -->
    <x-admin.search :placeholder="'Search users by name, email or school...'" />

    <!-- 🧑‍🤝‍🧑 Users Grid -->
    <x-admin.user-grid :users="$users" />


    <!-- ➕ Add User Modal -->
    <x-modal name="createUser" :show="false" maxWidth="xl">
        <div class="p-6">
            <h2 class="text-lg font-bold">Create New User</h2>

            <form wire:submit.prevent="createUser" wire:confirm.prompt="Are you sure?\n\nType SAVE to confirm|SAVE"
                class="mt-4">

                <div>
                    <div class="mb-10  border-gray-200">
                        <x-input-label for="school" :value="__('Search School')" />

                        <!-- Search Input -->
                        <input type="text" wire:model.live.debounce.300ms="schoolSearch"
                            placeholder="Type to search school..."
                            class="mt-2 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />

                        <!-- Select Dropdown -->
                        <select wire:model.defer="school_id"
                            class="mt-4 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                            <option value="" selected>--Select a school--</option>
                            @foreach($schools as $school)
                            <option value="{{ $school->id }}">{{ $school->school_name }}</option>
                            @endforeach
                        </select>

                        <x-input-error class="mt-2" :messages="$errors->get('school_id')" />
                    </div>


                    <div>
                        <x-input-label for="first_name" :value="__('First Name')" />
                        <input type="text" wire:model.defer="first_name"
                            class="mt-4 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                        <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                    </div>
                    <div>
                        <x-input-label for="last_name" :value="__('Last Name')" />
                        <input type="text" wire:model.defer="last_name"
                            class="mt-4 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                        <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                    </div>
                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <input type="text" wire:model.defer="email"
                            class="mt-4 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                    <div>
                        <x-input-label for="sex" :value="__('Sex')" />
                        <select wire:model.defer="sex"
                            class="mt-4 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                            <option value="" selected>--Select Gender--</option>

                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('sex')" />
                    </div>
                    <div>
                        <x-input-label for="type" :value="__('Type')" />
                        <select wire:model.defer="type"
                            class="mt-4 w-full border rounded-md dark:text-gray-700 dark:bg-purple-300 p-2">
                            <option value="" selected>--Select Type--</option>
                            <option value="student">Student</option>
                            <option disabled value="teacher">Teacher</option>
                            <option disabled value="guardian">Guardian</option>
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->get('type')" />
                    </div>


                    <div class="mt-6 flex justify-end">
                        <button type="button" x-on:click="$dispatch('close-modal', 'createUser')"
                            class="mr-2 px-4 py-2 bg-gray-500 text-white rounded-md">
                            Cancel
                        </button>

                        <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md">
                            Save
                        </button>

                        <div class="px-4 py-2 text-purple-700" wire:loading>
                            Saving post...
                        </div>
                        <!-- ✅ success message beside button -->
                        <span x-show="success" x-transition class="px-4 py-2 text-green-400 text-sm font-medium">
                            ✅ User created successfully!
                        </span>
                    </div>
            </form>

        </div>
    </x-modal>
</div>

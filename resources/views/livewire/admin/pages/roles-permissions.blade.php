<div class="p-4 space-y-6">
    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg shadow">
            {{ session('success') }}
        </div>
    @endif

    @foreach($roles as $role)
        <form wire:submit.prevent="updateRolePermissions({{ $role->id }})" class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-4">
                <h2 class="text-lg font-semibold mb-2 text-gray-800 dark:text-gray-100">
                    {{ ucfirst($role->name) }}
                </h2>
                <hr class="mb-4">

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($models as $model)
                        <div class="border rounded-lg p-3 shadow-sm bg-gray-50 dark:bg-gray-700">
                            <h3 class="text-md font-medium mb-2 capitalize text-gray-700 dark:text-gray-200">
                                {{ $model }}
                            </h3>
                            <div class="flex flex-wrap gap-3">
                                @foreach($actions as $action)
                                    @php
                                        $permName = "{$model}.{$action}";
                                        // Now, we need to generate the *same sanitized key*
                                        // that was used when building the permissionsMatrix in the component.
                                        // Since $this->sep is now public, we can access it.
                                        $sanitizedKeyForBinding = str_replace('.', $this->sep, $permName);
                                    @endphp
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox"
                                               wire:model.defer="permissionsMatrix.{{ $role->id }}.{{ $sanitizedKeyForBinding }}"
                                               class="rounded text-blue-600 focus:ring-blue-500">
                                        <span class="text-sm capitalize text-gray-600 dark:text-gray-300">
                                            {{ $action }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg shadow">
                    Update {{ ucfirst($role->name) }}
                </button>
            </div>
        </form>
    @endforeach
</div>
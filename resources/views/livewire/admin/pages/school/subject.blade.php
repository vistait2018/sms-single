<div class="p-6">
    {{-- Flash Messages --}}
    @if (session('status'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4 flex justify-between items-center">
            {{ session('status') }}
            <button class="ml-2 text-green-700 hover:text-green-900" onclick="this.parentElement.remove()">
                <!-- X-Mark Icon -->
                <svg xmlns="http://www.w3.org/2000/svg" 
                     fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                     class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" 
                          d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    @endif

    {{-- Search + Create --}}
    <div class="flex justify-between mb-6">
        <input type="text" wire:model.live="search"
            placeholder="Search subjects..."
            class="px-4 py-2 border rounded w-1/2">

        <button wire:click="create"
            class="flex items-center bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            <!-- Plus Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" 
                 fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                 class="w-5 h-5 mr-1">
                <path stroke-linecap="round" stroke-linejoin="round" 
                      d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            Add Subject
        </button>
    </div>

    {{-- Form --}}
    @if ($showForm)
        <div class="bg-gray-50 p-6 rounded-lg shadow mb-6">
            <h3 class="text-lg text-gray-500 font-semibold mb-4 flex items-center">
                @if($editMode)
                    <!-- Pencil Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                         class="w-5 h-5 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652l-9.193 9.193a4.5 
                              4.5 0 01-1.897 1.13L6 17.25l1.476-4.11a4.5 
                              4.5 0 011.13-1.897l8.256-8.256z" />
                    </svg>
                    Edit Subject
                @else
                    <!-- Plus Icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                         class="w-5 h-5 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" 
                              d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Add New Subject
                @endif
            </h3>

            <form wire:submit.prevent="{{ $editMode ? 'update' : 'store' }}" class="space-y-4">
                <div>
                    <label class="block font-medium mb-1 text-gray-500">Name</label>
                    <input type="text" wire:model="name" class="w-full px-4 py-2  bg-purple-200 text-gray-500 rounded">
                    @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>
                {{-- <div>
                    <label class="block font-medium mb-1 text-gray-500">Department</label>
                    <select wire:model="deptId" class="w-full px-4 py-2  bg-purple-200 text-gray-500 rounded">
                        <option disabled selected>-- SELECT DEPARTMENT</option>
                        @foreach ($departments as $dept )
                           <option value={{ $dept->id }}>{{  $dept->name }}</option> 
                        @endforeach
                    </select>
                    <input type="text" wire:model="name" class="w-full px-4 py-2  bg-purple-200 text-gray-500 rounded">
                    @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div> --}}
                <div class="flex space-x-2">
                    <button type="submit"
                        class="flex items-center bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        <!-- Check Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                             class="w-5 h-5 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                  d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                        {{ $editMode ? 'Update' : 'Save' }}
                    </button>
                    <button type="button" wire:click="$set('showForm', false)"
                        class="flex items-center bg-gray-400 text-white px-4 py-2 rounded hover:bg-gray-500">
                        <!-- X-Mark Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                             class="w-5 h-5 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                  d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- Subject Cards --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($subjects as $subj)
            <div class="bg-white shadow rounded-lg p-4 flex flex-col justify-between">
                <div>
                    <h4 class="text-lg font-bold text-gray-800">{{ $subj->name }}</h4>
                    <p class="text-gray-500 text-sm">School ID: {{ $subj->school_id }}</p>
                    <p class="text-xs text-gray-400 mt-1">Created {{ $subj->created_at->diffForHumans() }}</p>
                </div>
                <div class="mt-4 flex space-x-2">
                    <button wire:click="edit({{ $subj->id }})"
                        class="flex items-center bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                        <!-- Pencil Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                             class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                  d="M16.862 4.487l1.687-1.688a1.875 
                                  1.875 0 112.652 2.652l-9.193 9.193a4.5 
                                  4.5 0 01-1.897 1.13L6 17.25l1.476-4.11a4.5 
                                  4.5 0 011.13-1.897l8.256-8.256z" />
                        </svg>
                        Edit
                    </button>
                    <button wire:confirm.prompt="Are you sure you want to delete Subject?\n\nType DELETE to confirm|DELETE" wire:click="delete({{ $subj->id }})"
                        class="flex items-center bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                        <!-- Trash Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" 
                             fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
                             class="w-4 h-4 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                  d="M6 18L18 6M6 6l12 12" />
                            <path stroke-linecap="round" stroke-linejoin="round" 
                                  d="M9 9l6 6m0-6l-6 6" />
                        </svg>
                        Delete
                    </button>
                </div>
            </div>
        @empty
            <p class="text-gray-600">No subjects found.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $subjects->links() }}
    </div>
</div>

<div class="p-4 space-y-6 max-w-6xl mx-auto">

    {{-- Week selector with search + pagination --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 space-y-3">
        <h1 class="text-lg font-bold text-purple-700 dark:text-purple-300">Attendance Register</h1>

        {{-- Search Week --}}
        <input type="text" wire:model.live.debounce.500ms="searchWeek" placeholder="Search week..." class="w-full px-3 py-2 rounded-lg border border-purple-300 dark:border-purple-600
                      bg-white dark:bg-gray-800 text-sm text-gray-700 dark:text-gray-300
                      focus:ring focus:ring-purple-500">

        {{-- Week Dropdown --}}
        <select wire:model.live="selectedWeek" class="w-full sm:w-auto px-3 py-2 rounded-lg border border-purple-300 dark:border-purple-600
                   bg-white dark:bg-gray-800 text-sm">
            @foreach($weeks as $week)
            <option value="{{ $week->id }}">Week {{ $week->number }} | week {{ $week->id }}</option>
            @endforeach
        </select>

        {{-- Weeks Pagination --}}
        <div class="mt-2">
            {{ $weeks->links() }}
        </div>
    </div>

    {{-- Levels Section --}}
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-4 space-y-4">
        <div class="flex flex-col sm:flex-row justify-between gap-3">
            <h2 class="font-semibold text-purple-600 dark:text-purple-400">Classes / Levels</h2>

            {{-- Search Level --}}
            <input type="text" wire:model.live.debounce.500ms="searchLevel" placeholder="Search class/level..." class="w-full sm:w-1/3 px-3 py-2 rounded-lg border border-purple-300 dark:border-purple-600
                          bg-white dark:bg-gray-800 text-sm text-gray-700 dark:text-gray-300
                          focus:ring focus:ring-purple-500">
        </div>

        {{-- Levels List --}}
        @foreach($levels as $level)
        <div class="border rounded-lg p-4 bg-gray-50 dark:bg-gray-900 shadow-sm space-y-4">
            {{-- Level Header --}}
            <div class="flex justify-between items-center">
              <div>
                <h3 class="font-medium text-purple-700 dark:text-purple-300">
                    {{ $level->name }}
                    @php
                    $week = $weeks->firstWhere('id',$selectedWeek);
                    $start = \Carbon\Carbon::parse($week?->start_date)->startOfWeek(\Carbon\Carbon::MONDAY);
                    $end = $start->copy()->addDays(4); // Friday
                    @endphp

                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400 font-normal">
                        ({{ $start->format('D d M') }} – {{ $end->format('D d M') }})
                    </span>
                </h3>

            </div>
            <div>
                 @php
          $hasExisting = \App\Models\Attendance::where('level_id', $level->id)
              ->where('week_id', $selectedWeek)
              ->where('school_id', auth()->user()->school_id)
              ->exists();
      @endphp

      @if(!$hasExisting)
          @php
              // Check if everything is already selected in Livewire state
              $allSelected = true;
              foreach($level->students as $student) {
                  foreach(range(0,4) as $dayIndex) {
                      $date = \Carbon\Carbon::parse($week?->start_date)->addDays($dayIndex)->format('Y-m-d');
                      if (empty($attendanceData[$level->id][$student->id][$date]['morning']) ||
                          empty($attendanceData[$level->id][$student->id][$date]['afternoon'])) {
                          $allSelected = false;
                          break 2;
                      }
                  }
              }
          @endphp

          <label class=" ml-3 flex items-center gap-1 text-sm text-purple-600 cursor-pointer">
              <input type="checkbox"
                     wire:click="toggleLevelAttendance({{ $level->id }}, $event.target.checked)"
                     @checked($allSelected)
                     class="rounded text-purple-600 focus:ring-purple-500">
              {{ $allSelected ? 'Deselect All' : 'Select All' }}
          </label>
         <div wire:loading wire:target="toggleLevelAttendance" wire:key="toggle-loader-{{ $level->id }}">
    Loading level {{ $level->name }}...
</div>

      @endif
            </div>

                 {{-- <input type="checkbox"
                                    wire:click.live="toggleLevelAttendance({{ $level->id }}, $event.target.checked)"
                                    class="rounded text-purple-600 focus:ring-purple-500"> --}}
            </div>


            {{-- Attendance Table --}}
            <div class="overflow-x-auto">
                <table class="w-full text-sm border border-gray-300 dark:border-gray-700 border-collapse">
                    <thead class="bg-purple-100 dark:bg-purple-800 text-purple-700 dark:text-purple-200">
                        <tr>
                            <th class="p-2 text-left border">#</th>
                            <th class="p-2 text-left border">Name</th>
                            <th class="p-2 text-left border">Sex</th>
                            @foreach(['Mon','Tue','Wed','Thu','Fri'] as $day)
                            <th class="p-2 text-center border" colspan="2">
                                {{ $day }}
                            </th>
                            @endforeach
                        </tr>
                        <tr>
                            <th class="border"></th>
                            <th class="border"></th>
                            <th class="border text-right pr-2">
                                {{-- Select All checkbox for this level --}}

                            </th>
                            @foreach(['Mon','Tue','Wed','Thu','Fri'] as $day)
                            <th class="p-1 text-center border">M</th>
                            <th class="p-1 text-center border">A</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($level->students as $student)
                        <tr class="border border-gray-300 dark:border-gray-700">
                            <td
                                class="p-2 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700">
                                {{ $loop->iteration }}
                            </td>
                            <td
                                class="p-2 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700">
                                {{ $student->first_name }} {{ $student->last_name }}
                            </td>
                            <td
                                class="p-2 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700">
                                {{ $student->sex }}
                            </td>
                            @foreach(range(0,4) as $dayIndex)
                            @php
                            $week = $weeks->firstWhere('id',$selectedWeek);
                            $date = \Carbon\Carbon::parse($week?->start_date)->addDays($dayIndex);
                            @endphp
                            <td class="p-2 text-center border border-gray-300 dark:border-gray-700">
                                <input type="checkbox"
                                    wire:model="attendanceData.{{ $level->id }}.{{ $student->id }}.{{ $date->format('Y-m-d') }}.morning"
                                    class="rounded text-purple-600 focus:ring-purple-500 {{  $date->isFuture() ? 'cursor-not-allowed opacity-50':'' }}"
                                     @disabled($date->isFuture())>
                            </td>
                            <td class="p-2 text-center border border-gray-300 dark:border-gray-700">
                                <input type="checkbox"
                                    wire:model="attendanceData.{{ $level->id }}.{{ $student->id }}.{{ $date->format('Y-m-d') }}.afternoon"
                                    class="rounded text-purple-600 focus:ring-purple-500 {{  $date->isFuture() ? 'cursor-not-allowed opacity-50':'' }}"                                     @disabled($date->isFuture()) >
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>



            <div class="flex justify-end mr-5">
                <button wire:click="saveLevelAttendance({{ $level->id }})" class="mt-3 px-4 py-2 rounded bg-purple-600 text-white text-sm font-medium hover:bg-purple-700
                       focus:outline-none focus:ring-2 focus:ring-purple-500">
                    Save {{ $level->name }}
                </button>

                <div wire:loading wire:target="saveLevelAttendance({{ $level->id }})"
                    class="ml-2 mt-3 px-4 py-2 text-sm text-gray-600 dark:text-gray-400">
                    Saving...
                </div>

                @if(isset($savedMessage[$level->id]))
                <div class="ml-2 mt-3 px-4 py-2 text-sm text-green-600 dark:text-green-400">
                    {{ $savedMessage[$level->id] }}
                </div>
                @endif
            </div>
        </div>
        @endforeach

        {{-- Levels Pagination --}}
        <div>
            {{ $levels->links() }}
        </div>
    </div>
</div>

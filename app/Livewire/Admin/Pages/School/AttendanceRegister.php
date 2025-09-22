<?php

namespace App\Livewire\Admin\Pages\School;

use Livewire\Component;
use App\Models\Level;
use App\Models\AttendanceWeek as Week;
use App\Models\Attendance;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Carbon\Carbon;
use Livewire\Attributes\On;

#[Layout('layouts.app')]
#[Title("Attendance Register")]
class AttendanceRegister extends Component
{
    use WithPagination;

    public $selectedWeek;
    public $attendanceData = [];

    public $searchWeek = '';
    public $searchLevel = '';
    public $year_id;
    public $savedMessage = [];
    public $term ;

    protected $paginationTheme = 'tailwind';

    public function updatingSearchWeek()
    {
        $this->resetPage('weeksPage');
    }

    public function updatingSearchLevel()
    {
        $this->resetPage('levelsPage');
    }

    public function updatedSelectedWeek()
    {
        $this->loadAttendance();
    }
    public function mount()
    {
       $year = \App\Models\Year::where('status', 'active')
            ->where('school_id', auth()->user()->school_id)
            ->first();
            $this->year_id = $year?->id;
            $this->term = $year?->term;

        // Find current/present week
        $today = now()->toDateString();
        $currentWeek = Week::where('year_id', $this->year_id)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->first();

        if ($currentWeek) {
            $this->selectedWeek = $currentWeek->id; // 👈 Auto-select present week
            $this->loadAttendance();                // 👈 Preload attendance data
        }
    }

    public function loadAttendance()
    {

        if (!$this->selectedWeek) return;

        $week = Week::find($this->selectedWeek);
        if (!$week) return;

        // Only load paginated levels with students
        $levels = $this->levelsQuery()->with('students')->paginate(5, ['*'], 'levelsPage');

        foreach ($levels as $level) {
            foreach ($level->students as $student) {
                foreach (range(0, 4) as $dayIndex) { // Mon–Fri
                    $date = Carbon::parse($week->start_date)->addDays($dayIndex);

                    foreach (['morning', 'afternoon'] as $session) {
                        $existing = Attendance::where([
                            'student_id' => $student->id,
                            'level_id'   => $level->id,
                            'week_id'    => $week->id,
                            'date'       => $date->toDateString(),
                            'session'    => $session,
                            'year_id'     => $this->year_id,
                            'school_id'  => auth()->user()->school_id,
                            'term' =>    $this->term,
                        ])->first();

                        $this->attendanceData[$level->id][$student->id][$date->format('Y-m-d')][$session] =
                            $existing?->present ?? false;
                    }
                }
            }
        }
    }

    #[On('clearSavedMessage')]
public function clearSavedMessage($levelId)
{
     unset($this->savedMessage[$levelId]);
}
    public function saveLevelAttendance($levelId)
    {
        try {
            $week = Week::find($this->selectedWeek);
            if (!$week) {
                dd("No week found for ID {$this->selectedWeek}");
            }
            if (!$week) return;

            if (!isset($this->attendanceData[$levelId])) return;

            foreach ($this->attendanceData[$levelId] as $studentId => $dates) {
                foreach ($dates as $date => $sessions) {
                    if (Carbon::parse($date)->isFuture()) {
                     continue;
                 }
                    foreach ($sessions as $session => $present) {
                        Attendance::updateOrCreate(
                            [
                                'student_id' => $studentId,
                                'level_id'   => $levelId,
                                'week_id'    => $week->id,
                                'date'       => $date,
                                'session'    => $session,
                                'year_id'    => $this->year_id,
                                'school_id'  => auth()->user()->school_id,
                                'term'       => $this->term,
                            ],
                            ['present' => $present]
                        );
                    }
                }
            }
            $this->loadAttendance();

            $week = \App\Models\Week::find($this->selectedWeek);
            $start = \Carbon\Carbon::parse($week?->start_date)->startOfWeek(\Carbon\Carbon::MONDAY);
            $end = $start->copy()->addDays(4);
            $this->savedMessage[$levelId] = "Attendance saved for {$start->format('D d M')} – {$end->format('D d M')}";
        // Clear after 60 seconds
$this->dispatch('clearSavedMessage', levelId: $levelId);
        } catch (\Exception $e) {

            $this->savedMessage[$levelId] = "❌ Error saving attendance.";
        }
    }
public function toggleLevelAttendance($levelId, $checked)
{
    $week = Week::find($this->selectedWeek);
    if (!$week) return;

    $level = Level::with('students')->find($levelId);
    if (!$level) return;

    $start = Carbon::parse($week->start_date)->startOfWeek(Carbon::MONDAY);

    foreach ($level->students as $student) {
        foreach (range(0, 4) as $dayIndex) {
            $date = $start->copy()->addDays($dayIndex)->format('Y-m-d');

            // Skip if attendance already saved in DB
            $alreadySaved = Attendance::where([
                'student_id' => $student->id,
                'level_id'   => $levelId,
                'week_id'    => $week->id,
                'date'       => $date,
                'year_id'    => $this->year_id,
                'school_id'  => auth()->user()->school_id,
            ])->exists();

            if ($alreadySaved) {
                continue;
            }

            // Update Livewire state only
            $this->attendanceData[$levelId][$student->id][$date]['morning']   = $checked;
            $this->attendanceData[$levelId][$student->id][$date]['afternoon'] = $checked;
        }
    }
}



    private function weeksQuery()
    {
        return Week::query()
            ->when(
                $this->searchWeek,
                fn($q) =>
                $q->where('number', 'like', "%{$this->searchWeek}%")
            )
            ->orderBy('number', 'asc');
    }

   private function levelsQuery()
{
    $user = auth()->user();

    return Level::query()
        ->where('school_id', $user->school_id) // ensure same school
        ->when(
            $this->searchLevel,
            fn($q) => $q->where('name', 'like', "%{$this->searchLevel}%")
        )
        ->when(
            $user->hasRole('class-teacher'), // adjust if you're using Spatie: $user->hasRole('class_teacher')
            function ($q) use ($user) {
                $teacher = $user->teacher; // relationship from User → Teacher
                if ($teacher) {
                    $q->whereHas('teachers', fn($tq) => $tq->where('teacher_id', $teacher->id));
                }
            }
        )
        ->orderBy('name', 'asc');
}

    public function render()
    {
        return view('livewire.admin.pages.school.attendance-register', [
            'weeks'  => $this->weeksQuery()->paginate(5, ['*'], 'weeksPage'),
            'levels' => $this->levelsQuery()->with('students')->paginate(5, ['*'], 'levelsPage'),
        ]);
    }
}

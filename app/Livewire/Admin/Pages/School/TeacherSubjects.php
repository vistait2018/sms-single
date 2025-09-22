<?php

namespace App\Livewire\Admin\Pages\School;

use App\Models\Teacher;
use App\Models\Department;
use App\Models\Year;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('Teacher Subjects')]
class TeacherSubjects extends Component
{
    use WithPagination;

    public $search = '';
    public $sex = '';
    public $selectedTeacher = null;
    public $selectedDepartment = null;
    public $selectedLevel = null;
    public $subjects = [];
    public $levels = [];
    public $show = false;

 

public function clearSelection()
{
    $this->selectedTeacher = null;
}

    protected $updatesQueryString = ['search', 'sex'];

    public function selectTeacher($teacherId)
    {
        $this->selectedTeacher = Teacher::with('subjects')->find($teacherId);
        $this->reset(['selectedDepartment', 'selectedLevel', 'subjects', 'levels']);
    }

    public function updatedSelectedDepartment($departmentId)
    {
        $this->selectedLevel = null;
        $this->subjects = [];

        if ($departmentId) {
            $department = Department::with('levels')->find($departmentId);
            $this->levels = $department?->levels ?? collect();
        }
    }

    public function updatedSelectedLevel($levelId)
    {
        $this->subjects = [];

        if ($levelId && $this->selectedDepartment && $this->selectedTeacher) {
            $department = Department::with('subjects')->find($this->selectedDepartment);

           $this->subjects = $department?->subjects->map(function ($subject) use ($levelId) {
    return [
        'id' => $subject->id,
        'name' => $subject->name,
        'checked' => $this->selectedTeacher->subjects()
            ->wherePivot('level_id', $levelId)
            ->wherePivot('active', true) // 👈 only active ones
            ->where('subject_id', $subject->id)
            ->exists(),
    ];
})->toArray();

        }
    }

  public function toggleSubject($subjectId)
{
    if (!$this->selectedTeacher || !$this->selectedLevel) {
        return;
    }

    $year_id = Year::where('status', 'active')
        ->where('school_id', auth()->user()->school_id)
        ->first()?->id;

   $pivot = $this->selectedTeacher->subjects()
    ->wherePivot('level_id', $this->selectedLevel)
    ->wherePivot('subject_id', $subjectId)
    ->first();


    if ($pivot) {
        // Instead of detach, mark inactive
        $this->selectedTeacher->subjects()->updateExistingPivot($subjectId, [
            'active'   => false,
            'year_id'  => $year_id,
            'level_id' => $this->selectedLevel,
        ]);
    } else {
        // Attach new with active = true
        $this->selectedTeacher->subjects()->attach($subjectId, [
            'year_id'  => $year_id,
            'active'   => true,
            'level_id' => $this->selectedLevel,
        ]);
    }

    $this->updatedSelectedLevel($this->selectedLevel);
    $this->selectedTeacher->refresh();
}


    public function saveChanges()
{
    if (!$this->selectedTeacher || !$this->selectedLevel || !$this->selectedDepartment) {
        session()->flash('error', 'Please select a teacher, department, and class before saving.');
        return;
    }

    $year_id = Year::where('status', 'active')
        ->where('school_id', auth()->user()->school_id)
        ->first()?->id;

    $selectedSubjectIds = collect($this->subjects)
        ->filter(fn($subject) => $subject['checked'])
        ->pluck('id')
        ->toArray();

    foreach ($this->subjects as $subject) {
        if (in_array($subject['id'], $selectedSubjectIds)) {
            // mark active
            $this->selectedTeacher->subjects()->syncWithoutDetaching([
                $subject['id'] => [
                    'year_id'  => $year_id,
                    'active'   => true,
                    'level_id' => $this->selectedLevel,
                ],
            ]);
        } else {
            // mark inactive instead of detach
            $this->selectedTeacher->subjects()->updateExistingPivot($subject['id'], [
                'active'   => false,
                'year_id'  => $year_id,
                'level_id' => $this->selectedLevel,
            ]);
        }
    }

    $this->selectedTeacher->load('subjects');

    session()->flash('status', 'Subjects updated successfully!');
}
public function updatedSearch()
{
    $this->resetPage();
}
    public function render()
    {
     $teachers = Teacher::query()
    ->with(['subjects' => fn($q) =>
        $q->wherePivot('active', true)
          ->with('departments')
    ])
    ->where('school_id', auth()->user()->school_id)
    ->when($this->search, function ($q) {
        $q->where(function ($subQuery) {
            $subQuery->where('last_name', 'like', "%{$this->search}%")
                     ->orWhere('first_name', 'like', "%{$this->search}%");
        });
    })
    ->when($this->sex, fn($q) => $q->where('sex', $this->sex))
    ->paginate(1); // maybe use 10 instead of 1

     if($teachers->count() > 0){
         $this->show = true;
        }
        else{
            $this->show = false;
        }

        $departments = Department::where('school_id', auth()->user()->school_id)->get();

        return view('livewire.admin.pages.school.teacher-subjects', [
            'teachers' => $teachers,
            'departments' => $departments,
        ]);
    }
}

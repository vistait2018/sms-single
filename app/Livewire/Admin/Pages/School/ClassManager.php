<?php

namespace App\Livewire\Admin\Pages\School;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use App\Models\Level;
use App\Models\Student;
use App\Models\Department;
use App\Models\Year;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
#[Title('Class Manager')]
class ClassManager extends Component
{
    use WithPagination;

    public $newClassName = '';
    public $year = [];
    public $selectedClass = null;
    public $studentSearch = '';

    public $selectedDepartment = null; // for new class
    public $editDepartment = null;     // for updating existing class

    protected $paginationTheme = 'tailwind';

    protected $rules = [
        'newClassName' => 'required|string|max:255',
    ];

    public function mount()
    {
        $year = Year::where('status', 'active')->first();
        $this->year = $year ? $year->toArray() : [];
        if (!$year) {
            session()->flash('error', 'No active academic year found');
        }
    }

    public function addClass()
    {
        $this->validate();

        $class = Level::create([
            'school_id' => Auth::user()->school_id,
            'name' => $this->newClassName,
        ]);

        if ($this->selectedDepartment) {
            $class->departments()->sync([
                $this->selectedDepartment => ['year_id' => $this->year['id']]
            ]);
        }

        $this->reset(['newClassName', 'selectedDepartment']);

        session()->flash('success', 'Class added successfully ✅');
    }

    public function selectClass($classId)
    {
        $this->selectedClass = Level::with(['students.user', 'departments'])
            ->where('school_id', Auth::user()->school_id)
            ->findOrFail($classId);

        $this->editDepartment = $this->selectedClass->departments->pluck('id')->first();
        $this->resetPage();
    }

    public function updateClassDepartment()
    {
        if ($this->selectedClass) {
            if ($this->editDepartment) {
                $this->selectedClass->departments()->sync([
                    $this->editDepartment => ['year_id' => $this->year['id']]
                ]);
            } else {
                $this->selectedClass->departments()->detach();
            }

            $this->selectedClass->load('departments');
            session()->flash('success', 'Department updated successfully ✅');
        }
    }

    public function render()
    {
        $classes = Level::where('school_id', Auth::user()->school_id)
            ->orderBy('name')
            ->get();

        $departments = Department::where('school_id', Auth::user()->school_id)->get();

        $students = collect();

        if ($this->selectedClass) {
            $activeYearId = $this->year['id'] ?? null;

            $students = $this->selectedClass->students()
                ->with('user')
                ->wherePivot('active', true)
                ->wherePivot('year_id', $activeYearId)
                ->where(function ($q) {
                    $q->where('students.first_name', 'like', "%{$this->studentSearch}%")
                      ->orWhere('students.last_name', 'like', "%{$this->studentSearch}%")
                      ->orWhere('students.sex', 'like', "%{$this->studentSearch}%")
                      ->orWhereHas('user', function ($sub) {
                          $sub->where('email', 'like', "%{$this->studentSearch}%")
                              ->orWhere('name', 'like', "%{$this->studentSearch}%");
                      });
                })
                ->orderBy('students.first_name')
                ->paginate(10);
        }

        return view('livewire.admin.pages.school.class-manager', [
            'classes' => $classes,
            'students' => $students,
            'departments' => $departments,
        ]);
    }
}

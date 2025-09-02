<?php

namespace App\Livewire\Admin\Pages\School;





use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Department;
use App\Models\Subject;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;


#[Layout('layouts.app')]
#[Title('Department subjects')]
class DepartmentSubjects extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedDepartment = null;
    public $selectedSubjects = [];

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function selectDepartment($departmentId)
    {
        $this->selectedDepartment = Department::with('subjects')
            ->where('school_id', Auth::user()->school_id)
            ->findOrFail($departmentId);

        $this->selectedSubjects = $this->selectedDepartment->subjects->pluck('id')->toArray();
    }

    public function saveSubjects()
    {
        if (!$this->selectedDepartment) {
            return;
        }

        $this->selectedDepartment->subjects()->sync($this->selectedSubjects);

        session()->flash('success', 'Subjects updated successfully ✅');
    }

  public function render()
{
    $departments = Department::where('school_id', Auth::user()->school_id)
        ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
        ->orderBy('name')
        ->paginate(8);

    $totalDepartments = Department::where('school_id', Auth::user()->school_id)->count();

    $allSubjects = Subject::where('school_id', Auth::user()->school_id)
        ->orderBy('name')
        ->get();

    return view('livewire.admin.pages.school.department-subjects', [
        'departments' => $departments,
        'allSubjects' => $allSubjects,
        'totalDepartments' => $totalDepartments,
    ]);
}

}

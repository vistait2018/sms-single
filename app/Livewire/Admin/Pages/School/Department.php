<?php

namespace App\Livewire\Admin\Pages\School;

use App\Models\Department as DepartmentModel;
use App\Models\School;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('School Departments')]
class Department extends Component
{
    use WithPagination;

    public $search = '';
    public $name;
    public $school;
    public $school_id;
    public $departmentId;
    public $showForm = false;
    public $editMode = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'school_id' => 'required|exists:schools,id',
    ];

   public function mount()
{
    if (Auth::check() && Auth::user()->school) {
        $this->school = Auth::user()->school;
        $this->school_id = $this->school->id;
    }
}

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->reset(['name',  'departmentId', 'editMode']);
        $this->showForm = true;
    }

    public function store()
    {
        $this->validate();

        DepartmentModel::create([
            'name' => $this->name,
            'school_id' => $this->school_id,
        ]);

        session()->flash('status', '✅ Department created successfully!');
        $this->reset(['name',  'showForm']);
       $this->resetPage();
    }

    public function edit($id)
    {
        $dept = DepartmentModel::findOrFail($id);

        $this->departmentId = $dept->id;
        $this->name = $dept->name;
        $this->school_id = $dept->school_id;
        $this->editMode = true;
        $this->showForm = true;
    }

    public function update()
    {
        $this->validate();

        $dept = DepartmentModel::findOrFail($this->departmentId);
        $dept->update([
            'name' => $this->name,
            'school_id' => $this->school_id,
        ]);

        session()->flash('status', '✅ Department updated successfully!');
        $this->reset(['name', 'school_id', 'departmentId', 'editMode', 'showForm']);
    }

    public function delete($id)
    {
        DepartmentModel::findOrFail($id)->delete();
        session()->flash('status', '🗑 Department deleted!');
    }

    public function render()
    {
        $departments = DepartmentModel::with('school')
            ->where('name', 'like', "%{$this->search}%")
            ->latest()
            ->paginate(6);

        return view('livewire.admin.pages.school.department', [
            'departments' => $departments,
        ]);
    }
}

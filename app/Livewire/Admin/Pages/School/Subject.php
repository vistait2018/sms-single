<?php

namespace App\Livewire\Admin\Pages\School;

use App\Models\Department as DepartmentModel;
use App\Models\School;
use App\Models\Subject as ModelsSubject;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title('School Departments')]
class Subject extends Component
{
    use WithPagination;

    public $search = '';
    public $name;
    public $school;
    public $school_id;
    public $subjectId;
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
        $this->reset(['name',  'subjectId', 'editMode']);
        $this->showForm = true;
    }

    public function store()
    {
        $this->validate();

        ModelsSubject::create([
            'name' => $this->name,
            'school_id' => $this->school_id,
        ]);

        session()->flash('status', '✅ Suject created successfully!');
        $this->reset(['name',  'showForm']);
       $this->resetPage();
    }

    public function edit($id)
    {
        $sub = ModelsSubject::findOrFail($id);

        $this->subjectId = $sub->id;
        $this->name = $sub->name;
        $this->school_id = $sub->school_id;
        $this->editMode = true;
        $this->showForm = true;
    }

    public function update()
    {
        $this->validate();

        $sub = ModelsSubject::findOrFail($this->subjectId);
        $sub->update([
            'name' => $this->name,
            'school_id' => $this->school_id,
        ]);

        session()->flash('status', '✅ Subject updated successfully!');
        $this->reset(['name', 'school_id',  'editMode', 'showForm']);
    }

    public function delete($id)
    {
        ModelsSubject::findOrFail($id)->delete();
        session()->flash('status', '🗑 Subject deleted!');
    }

    public function render()
    {
        $subjects = ModelsSubject::with('school')
            ->where('name', 'like', "%{$this->search}%")
            ->latest()
            ->paginate(6);
            

        return view('livewire.admin.pages.school.subject', [
            'subjects' => $subjects,
        ]);
    }
}

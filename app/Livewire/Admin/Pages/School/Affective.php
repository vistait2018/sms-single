<?php

namespace App\Livewire\Admin\Pages\School;

use App\Models\SchoolAffective;
use App\Models\SchoolGradeKey;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
#[Title('School Affectives')]
class Affective extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    // Properties for creation
    public $name;
    public $min_level;
    public $max_level;

    // Editing state
    public $editingId = null;
    public $edit_name;
    public $edit_min_level;
    public $edit_max_level;
    public $grade_key_min_level;
    public $grade_key_max_level;

    // Search
    public $search = '';

    public function mount(){
       
        $key =SchoolGradeKey::where('school_id', auth()->user()->school_id)
        ->first();
       
       $this->grade_key_min_level = $key->min('grade_level')?? 1;
       $this->grade_key_max_level = $key->max('grade_level')?? 5;
    
    }

   protected function rules()
{
    if ($this->editingId) {
        return [
            'edit_name'       => 'required|string|max:20',
            'edit_min_level'  => 'required|integer|min:' . $this->grade_key_min_level . '|max:' . $this->grade_key_max_level,
            'edit_max_level'  => 'required|integer|min:' . $this->grade_key_min_level . '|max:' . $this->grade_key_max_level,
        ];
    }

    return [
        'name'       => 'required|string|max:20',
        'min_level'  => 'required|integer|min:' . $this->grade_key_min_level . '|max:' . $this->grade_key_max_level,
        'max_level'  => 'required|integer|max:' . $this->grade_key_max_level . '|max:' . $this->grade_key_max_level,
    ];
}


    public function createGrade()
    {
        $this->validate();

        SchoolAffective::create([
            'school_id'  => Auth::user()->school_id,
            'name'       => $this->name,
            'min_level'  => $this->min_level,
            'max_level'  => $this->max_level,
        ]);

        session()->flash('status', 'Grade created successfully!');
        $this->reset(['name', 'min_level', 'max_level']);
        $this->resetPage();
    }

    public function startEdit($id)
    {
        $grade = SchoolAffective::findOrFail($id);
        $this->editingId     = $id;
        $this->edit_name     = $grade->name;
        $this->edit_min_level = $grade->min_level;
        $this->edit_max_level = $grade->max_level;
    }

    public function updateGrade()
    {
        $this->validate();

        SchoolAffective::where('id', $this->editingId)->update([
            'name'      => $this->edit_name,
            'min_level' => $this->edit_min_level,
            'max_level' => $this->edit_max_level,
        ]);

        session()->flash('status', 'Grade updated successfully!');
        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->reset(['editingId', 'edit_name', 'edit_min_level', 'edit_max_level']);
    }

    public function render()
    {
        $grades = SchoolAffective::where('school_id', Auth::user()->school_id)
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderBy('min_level', 'desc')
            ->paginate(10);

        return view('livewire.admin.pages.school.affective', [
            'grades' => $grades
        ]);
    }
}

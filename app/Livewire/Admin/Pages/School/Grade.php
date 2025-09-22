<?php

namespace App\Livewire\Admin\Pages\School;

use App\Models\SchoolGrade;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
#[Title('School Grades')]
class Grade extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    // Properties for creation
    public $grade_name;
    public $min_level;
    public $max_level;

    // Editing state
    public $editingId = null;
    public $edit_grade_name;
    public $edit_min_level;
    public $edit_max_level;

    // Search
    public $search = '';

   protected function rules()
{
    if ($this->editingId) {
        return [
            'edit_grade_name' => 'required|string|max:100',
            'edit_min_level'  => 'required|integer|min:0|max:100',
            'edit_max_level'  => 'required|integer|min:0|max:100|gte:edit_min_level',
        ];
    }

    return [
        'grade_name' => 'required|string|max:100',
        'min_level'  => 'required|integer|min:0|max:100',
        'max_level'  => 'required|integer|min:0|max:100|gte:min_level',
    ];
}

protected function messages()
{
    return [
        // Create
        'grade_name.required' => 'Grade name is required.',
        'grade_name.string'   => 'Grade name must be text.',
        'grade_name.max'      => 'Grade name cannot be longer than 100 characters.',

        'min_level.required'  => 'Minimum level is required.',
        'min_level.integer'   => 'Minimum level must be a number.',
        'min_level.min'       => 'Minimum level cannot be less than 0.',
        'min_level.max'       => 'Minimum level cannot be greater than 100.',

        'max_level.required'  => 'Maximum level is required.',
        'max_level.integer'   => 'Maximum level must be a number.',
        'max_level.min'       => 'Maximum level cannot be less than 0.',
        'max_level.max'       => 'Maximum level cannot be greater than 100.',
        'max_level.gte'       => 'Maximum level must be greater than or equal to the minimum level.',

        // Edit
        'edit_grade_name.required' => 'Grade name is required when editing.',
        'edit_grade_name.string'   => 'Grade name must be text.',
        'edit_grade_name.max'      => 'Grade name cannot be longer than 100 characters.',

        'edit_min_level.required'  => 'Minimum level is required when editing.',
        'edit_min_level.integer'   => 'Minimum level must be a number.',
        'edit_min_level.min'       => 'Minimum level cannot be less than 0.',
        'edit_min_level.max'       => 'Minimum level cannot be greater than 100.',

        'edit_max_level.required'  => 'Maximum level is required when editing.',
        'edit_max_level.integer'   => 'Maximum level must be a number.',
        'edit_max_level.min'       => 'Maximum level cannot be less than 0.',
        'edit_max_level.max'       => 'Maximum level cannot be greater than 100.',
        'edit_max_level.gte'       => 'Maximum level must be greater than or equal to the minimum level.',
    ];
}


    public function createGrade()
    {
        $this->validate();

        SchoolGrade::create([
            'school_id'  => Auth::user()->school_id,
            'grade_name' => $this->grade_name,
            'min_level'  => $this->min_level,
            'max_level'  => $this->max_level,
        ]);

        session()->flash('status', 'Grade created successfully!');
        $this->reset(['grade_name', 'min_level', 'max_level']);
        $this->resetPage();
    }

    public function startEdit($id)
    {
        $grade = SchoolGrade::findOrFail($id);
        $this->editingId = $id;
        $this->edit_grade_name = $grade->grade_name;
        $this->edit_min_level = $grade->min_level;
        $this->edit_max_level = $grade->max_level;
    }

    public function updateGrade()
    {
        $this->validate();

        SchoolGrade::where('id', $this->editingId)->update([
            'grade_name' => $this->edit_grade_name,
            'min_level'  => $this->edit_min_level,
            'max_level'  => $this->edit_max_level,
        ]);

        session()->flash('status', 'Grade updated successfully!');
        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->reset(['editingId', 'edit_grade_name', 'edit_min_level', 'edit_max_level']);
    }

    public function render()
    {
        $grades = SchoolGrade::where('school_id', Auth::user()->school_id)
            ->when($this->search, fn($q) => $q->where('grade_name', 'like', "%{$this->search}%"))
            ->orderBy('min_level', 'desc')
            ->paginate(10);

        return view('livewire.admin.pages.school.grade', [
            'grades' => $grades
        ]);
    }
}

<?php

namespace App\Livewire\Admin\Pages\School;

use App\Models\SchoolGradeKey;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
#[Title('School Grade Keys')]
class GradeKeys extends Component
{
    use WithPagination;
    protected $paginationTheme = 'tailwind';

    // Properties for creation
    public $key_name;
    public $grade_level;

    // Editing state
    public $editingId = null;
    public $edit_key_name;
    public $edit_grade_level;

    // Search
    public $search = '';

   protected function rules()
{
    if ($this->editingId) {
        return [
            'edit_key_name'     => 'required|string|max:100',
            'edit_grade_level'  => 'required|integer|min:1|max:5',
        ];
    }

    return [
        'key_name'     => 'required|string|max:100',
        'grade_level'  => 'required|integer|min:1|max:5',
    ];
}

protected function messages()
{
    return [
        // Create
        'key_name.required'    => 'Grade name is required.',
        'key_name.string'      => 'Grade name must be text.',
        'key_name.max'         => 'Grade name cannot be longer than 100 characters.',
        'grade_level.required' => 'Grade level is required.',
        'grade_level.integer'  => 'Grade level must be a number.',
        'grade_level.min'      => 'Grade level must be at least 1.',
        'grade_level.max'      => 'Grade level cannot be more than 5.',

        // Edit
        'edit_key_name.required'    => 'Grade name is required when editing.',
        'edit_key_name.string'      => 'Grade name must be text.',
        'edit_key_name.max'         => 'Grade name cannot be longer than 100 characters.',
        'edit_grade_level.required' => 'Grade level is required when editing.',
        'edit_grade_level.integer'  => 'Grade level must be a number.',
        'edit_grade_level.min'      => 'Grade level must be at least 1.',
        'edit_grade_level.max'      => 'Grade level cannot be more than 5.',
    ];
}

    public function createGrade()
    {
        $this->validate();

        SchoolGradeKey::create([
            'school_id'    => Auth::user()->school_id,
            'key_name'     => $this->key_name,
            'grade_level'  => $this->grade_level,
        ]);

        session()->flash('status', 'Grade created successfully!');
        $this->reset(['key_name', 'grade_level']);
        $this->resetPage();
    }

    public function startEdit($id)
    {
        $grade = SchoolGradeKey::findOrFail($id);
        $this->editingId = $id;
        $this->edit_key_name = $grade->key_name;
        $this->edit_grade_level = $grade->grade_level;
    }

    public function updateGrade()
    {
        $this->validate();

        SchoolGradeKey::where('id', $this->editingId)->update([
            'key_name'     => $this->edit_key_name,
            'grade_level'  => $this->edit_grade_level,
        ]);

        session()->flash('status', 'Grade updated successfully!');
        $this->cancelEdit();
    }

    public function cancelEdit()
    {
        $this->reset(['editingId', 'edit_key_name', 'edit_grade_level']);
    }

    public function render()
    {
        $grades = SchoolGradeKey::where('school_id', Auth::user()->school_id)
            ->when($this->search, fn($q) =>
                $q->where('key_name', 'like', "%{$this->search}%")
                  ->orWhere('grade_level', 'like', "%{$this->search}%")
            )
            ->orderBy('grade_level', 'desc')
            ->paginate(10);

        return view('livewire.admin.pages.school.grade-keys', [
            'grades' => $grades
        ]);
    }
}

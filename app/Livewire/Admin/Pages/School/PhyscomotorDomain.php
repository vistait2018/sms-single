<?php


namespace App\Livewire\Admin\Pages\School;

use App\Models\SchoolPhyshomotor;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\SchoolGradeKey;

#[Layout('layouts.app')]
#[Title('School Psychomotor Domain')]
class PhyscomotorDomain extends Component
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

    protected function messages()
    {
        return [
            // Create
            'name.required' => 'Grade name is required.',
            'name.string'   => 'Grade name must be text.',
            'name.max'      => 'Grade name cannot be longer than 20 characters.',

            'min_level.required' => 'Minimum level is required.',
            'min_level.integer'  => 'Minimum level must be a number.',
            'min_level.min'      => 'Minimum level cannot be less than 1.',
            'min_level.max'      => 'Minimum level cannot be greater than 5.',

            'max_level.required' => 'Maximum level is required.',
            'max_level.integer'  => 'Maximum level must be a number.',
            'max_level.min'      => 'Maximum level cannot be less than 1.',
            'max_level.max'      => 'Maximum level cannot be greater than 5.',
            'max_level.gte'      => 'Maximum level must be greater than or equal to the minimum level.',

            // Edit
            'edit_name.required' => 'Grade name is required when editing.',
            'edit_name.string'   => 'Grade name must be text.',
            'edit_name.max'      => 'Grade name cannot be longer than 20 characters.',

            'edit_min_level.required' => 'Minimum level is required when editing.',
            'edit_min_level.integer'  => 'Minimum level must be a number.',
            'edit_min_level.min'      => 'Minimum level cannot be less than 1.',
            'edit_min_level.max'      => 'Minimum level cannot be greater than 5.',

            'edit_max_level.required' => 'Maximum level is required when editing.',
            'edit_max_level.integer'  => 'Maximum level must be a number.',
            'edit_max_level.min'      => 'Maximum level cannot be less than 1.',
            'edit_max_level.max'      => 'Maximum level cannot be greater than 5.',
            'edit_max_level.gte'      => 'Maximum level must be greater than or equal to the minimum level.',
        ];
    }

    public function createGrade()
    {
        $this->validate();

        SchoolPhyshomotor::create([
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
        $grade = SchoolPhyshomotor::findOrFail($id);
        $this->editingId     = $id;
        $this->edit_name     = $grade->name;
        $this->edit_min_level = $grade->min_level;
        $this->edit_max_level = $grade->max_level;
    }

    public function updateGrade()
    {
        $this->validate();

        SchoolPhyshomotor::where('id', $this->editingId)->update([
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
        $grades = SchoolPhyshomotor::where('school_id', Auth::user()->school_id)
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->orderBy('min_level', 'desc')
            ->paginate(10);

        return view('livewire.admin.pages.school.physcomotor-domain', [
            'grades' => $grades
        ]);
    }
}

<?php
namespace App\Livewire\Admin\Pages\School;

use App\Models\Level;
use App\Models\Teacher;
use App\Models\Year;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Class teachers')]
class MakeClassTeacher extends Component
{
    use WithPagination;

    public $search;
    public $selectedLevels = []; // store selected level per teacher

    public function mount()
    {
        $currentYear = Year::where('status', 'active')->first();
        if ($currentYear) {
            $teachers = Teacher::where('school_id', Auth::user()->school_id)->get();
            foreach ($teachers as $teacher) {
                $assignedLevel = $teacher->levels()
                    ->wherePivot('year_id', $currentYear->id)
                    ->wherePivot('active', true)
                    ->first();
                if ($assignedLevel) {
                    $this->selectedLevels[$teacher->id] = $assignedLevel->id;
                }
            }
        }
    }

  public function assignTeacher($teacher_id)
{
    $teacher = Teacher::findOrFail($teacher_id);
    $currentYear = Year::where('status', 'active')->first();

    if (!$currentYear) {
        session()->flash('error', 'No active academic year found.');
        return;
    }

    if (!empty($this->selectedLevels[$teacher_id])) {
        $newLevelId = $this->selectedLevels[$teacher_id];

        // 1️⃣ Deactivate any existing teacher assigned to this level in this year
        \DB::table('level_teacher')
            ->where('level_id', $newLevelId)
            ->where('year_id', $currentYear->id)
            ->where('active', true)
            ->update(['active' => false]);

        // 2️⃣ Assign this teacher to the level
        $pivotExists = $teacher->levels()
            ->wherePivot('year_id', $currentYear->id)
            ->wherePivot('level_id', $newLevelId)
            ->exists();

        if ($pivotExists) {
            $teacher->levels()->updateExistingPivot($newLevelId, ['active' => true]);
        } else {
            $teacher->levels()->attach($newLevelId, [
                'year_id' => $currentYear->id,
                'active'  => true,
            ]);
        }
    }

    session()->flash('status', 'Class teacher assigned successfully.');
}



    public function render()
    {
        $teachers = Teacher::where('school_id', Auth::user()->school_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', "%{$this->search}%")
                      ->orWhere('last_name', 'like', "%{$this->search}%")
                      ->orWhere('sex', 'like', "%{$this->search}%");
                });
            })
            ->latest()
            ->paginate(5);

        $levels = Level::where('school_id', Auth::user()->school_id)->get();

        return view('livewire.admin.pages.school.make-class-teacher', [
            'levels' => $levels,
            'teachers' => $teachers
        ]);
    }
}

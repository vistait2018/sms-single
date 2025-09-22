<?php

namespace App\Livewire\Admin\Pages\School;

use Livewire\Component;
use App\Models\Level;
use App\Models\Comments;
use App\Models\ResultExtra;
use App\Models\Year;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Validation\Rule;

#[Layout('layouts.app')]
#[Title('Student Result Info')]
class StudentResultInfo extends Component
{
    public $search = '';
    public $selectedLevel = null;
    public $students = [];
    public $comments = [];
    public $year_id;
    public $term;

    // Data for inputs
    public $formData = [];

    public function mount()
    {
        $this->comments = Comments::all();

        $year = Year::where('school_id', auth()->user()->school_id)
            ->where('status', 'active')
            ->first();

        $this->year_id = $year?->id;
        $this->term = $year?->term; // e.g. "first", "second", "third"
    }

    public function updatedSelectedLevel($levelId)
    {
        if ($levelId) {
            $level = Level::with('students')->find($levelId);
            $this->students = $level?->students ?? [];

            foreach ($this->students as $student) {
                // Check if record already exists
                $existing = ResultExtra::where('student_id', $student->id)
                    ->where('year_id', $this->year_id)
                    ->where('term', $this->term)
                    ->first();

                if ($existing) {
                    $this->formData[$student->id] = [
                        'affective_grade'   => $existing->affective_grade,
                        'psychomotor_grade' => $existing->psychomotor_grade,
                        'comment'           => $existing->comment,
                        'saved_at'          => $existing->updated_at->format('d M, Y H:i'),
                    ];
                } else {
                    $this->formData[$student->id] = [
                        'affective_grade'   => null,
                        'psychomotor_grade' => null,
                        'comment'           => null,
                        'saved_at'          => null,
                    ];
                }
            }
        }
    }

    public function save()
    {
        $rules = [];
        foreach ($this->formData as $studentId => $data) {
            $rules["formData.$studentId.affective_grade"]   = ['required', 'integer', 'between:1,5'];
            $rules["formData.$studentId.psychomotor_grade"] = ['required', 'integer', 'between:1,5'];
            $rules["formData.$studentId.comment"]           = ['required', 'string'];
        }

        $this->validate($rules, [
            'required' => 'This field is required.',
            'between'  => 'Value must be between 1 and 5.',
        ]);

        foreach ($this->formData as $studentId => $data) {
            $record = ResultExtra::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'year_id'    => $this->year_id,
                    'term'       => $this->term,
                ],
                [
                    'affective_grade'   => $data['affective_grade'],
                    'psychomotor_grade' => $data['psychomotor_grade'],
                    'comment'           => $data['comment'],
                ]
            );

            // Refresh the saved date in formData
            $this->formData[$studentId]['saved_at'] = $record->updated_at->format('d M, Y H:i');
        }

        session()->flash('success', 'Results Extra Info saved successfully!');
    }

    public function render()
    {
        $levels = Level::where('school_id', Auth::user()->school_id)
            ->where('name', 'like', "%{$this->search}%")
            ->get();

        return view('livewire.admin.pages.school.student-result-info', [
            'levels' => $levels,
        ]);
    }
}

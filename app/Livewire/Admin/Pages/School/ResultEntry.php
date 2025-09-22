<?php

namespace App\Livewire\Admin\Pages\School;

use Livewire\Component;
use App\Models\{Level, Student, Subject, Result, ResultSetting, Year};
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title("Student Results")]
class ResultEntry extends Component
{
    public $selectedLevel, $selectedSubject;
    public $students = [], $subjects = [], $scores = [];
    public $ca_total, $exam_total;
    public $currentYearId;
    public $currentTerm;
    public $selectedLevelName;
    public $edit = false;


    public function enableEdit()
    {
        if($this->edit === false){
            $this->edit = true;
        }
    }

    public function disableEdit()
    {
        if($this->edit === true){
            $this->edit = false;
        }
    }

    public function mount()
    {
        $user = Auth::user();
        $year = Year::where('school_id', $user->school_id)
            ->where('status', 'active')
            ->first();

        $this->currentYearId = $year->id ?? null;
        $this->currentTerm = $year->term ?? null;

         // Load result settings
       $settings=  ResultSetting::where('school_id', $user->school_id)
            ->where('year_id', $this->currentYearId)
            ->where('term', $this->currentTerm)
            ->first();

        $this->ca_total =  $settings->ca_total ?? 40;
        $this->exam_total = $settings->exam_total ?? 60;
    }

  public function updatedSelectedLevel($levelId)
{
    $level = Level::with(['departments.subjects', 'students'])->find($levelId);

    $this->selectedLevelName = $level->name ?? null;

    // Only active students for the current year
    $this->students = $level
        ? $level->students()
            ->wherePivot('year_id', $this->currentYearId)
            ->wherePivot('active', true)
            ->get()
        : collect();

    // Subjects via departments
    $this->subjects = $level
        ? $level->departments->flatMap->subjects->unique('id')->values()
        : collect();

    $this->scores = [];
    $this->selectedSubject = null;
}


public function updatedSelectedSubject($subjectId)
{
    $user = Auth::user();
    $teacher = $user->teacher;

    if (!$teacher) {
        $this->addError('subject', 'You are not assigned to any subject.');
        $this->selectedSubject = null;
        return;
    }

    // Check assignment
    $assigned = $teacher->subjects()
        ->where('subject_id', $subjectId)
        ->wherePivot('level_id', $this->selectedLevel)
        ->wherePivot('active', true)
        ->exists();

    if (!$assigned) {
        $this->addError('subject', 'You are not assigned to this subject for the selected level.');
        $this->selectedSubject = null;
        return;
    }

    // ✅ Load saved results for this subject
    $results = Result::where('school_id', $user->school_id)
        ->where('year_id', $this->currentYearId)
        ->where('term', $this->currentTerm)
        ->where('subject_id', $subjectId)
        ->get()
        ->keyBy('student_id');

    // Hydrate $scores for each student
    $this->scores = [];
    foreach ($this->students as $student) {
        $this->scores[$student->id] = [
            'ca' => $results[$student->id]->ca ?? null,
            'exam' => $results[$student->id]->exam ?? null,
        ];
    }
}


    public function saveResults()
    {
      $this->validate(
    [
        'scores.*.ca'   => "nullable|numeric|min:0|max:{$this->ca_total}",
        'scores.*.exam' => "nullable|numeric|min:0|max:{$this->exam_total}",
    ],
    [
        'scores.*.ca.numeric'   => 'Continuous Assessment (CA) must be a number.',
        'scores.*.ca.min'       => 'Continuous Assessment (CA) cannot be less than 0.',
        'scores.*.ca.max'       => "Continuous Assessment (CA) cannot be more than {$this->ca_total}.",

        'scores.*.exam.numeric' => 'Exam score must be a number.',
        'scores.*.exam.min'     => 'Exam score cannot be less than 0.',
        'scores.*.exam.max'     => "Exam score cannot be more than {$this->exam_total}.",
    ]
);


        foreach ($this->scores as $studentId => $score) {
            Result::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'year_id' => $this->currentYearId,
                    'term' => $this->currentTerm,
                    'school_id' => Auth::user()->school_id,
                    'subject_id' => $this->selectedSubject,
                ],
                [
        'ca' => min($score['ca'] ?? 0, $this->ca_total),
        'exam' => min($score['exam'] ?? 0, $this->exam_total),
        'user_id' => Auth::id(),
    ]
            );
        }
      // $this->edit = false;
        session()->flash('status', 'Results saved successfully!');
    }

    public function render()
    {

        return view('livewire.admin.pages.school.result-entry', [
            'levels' => Level::where('school_id', Auth::user()->school_id)->get(),
            'ca_total' => $this->ca_total,
            'exam_total' => $this->exam_total,
        ]);
    }
}

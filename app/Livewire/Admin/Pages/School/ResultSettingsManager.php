<?php

namespace App\Livewire\Admin\Pages\School;

use Livewire\Component;
use App\Models\ResultSetting;
use App\Models\Year;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title("Result Settings")]
class ResultSettingsManager extends Component
{
    public $terms = ['first', 'second', 'third'];
    public $selectedYearId;
    public $presentTerm;
    public $settings = []; // ['first' => [...], 'second'=> [...], 'third'=>[...]]

    public function mount()
    {
        $schoolId = Auth::user()->school_id;

        // Only active year
        $year = Year::where('school_id', $schoolId)->where('status', 'active')->first();
        if ($year) {
            $this->selectedYearId = $year->id;
            $this->presentTerm = $year->term;
        }

        // Initialize settings for the 3 terms
        foreach ($this->terms as $term) {
            $setting = ResultSetting::where('year_id', $this->selectedYearId)
                ->where('term', $term)
                ->where('school_id', $schoolId)
                ->first();

            $this->settings[$term] = [
                'id' => $setting?->id,
                'ca_total' => $setting?->ca_total ?? '',
                'exam_total' => $setting?->exam_total ?? '',
            ];
        }
    }

   public function saveTerm($term)
{
    $schoolId = Auth::user()->school_id;

    // Validation
    $ca = (int) $this->settings[$term]['ca_total'];
    $exam = (int) $this->settings[$term]['exam_total'];

    if (($ca + $exam) !== 100) {
        $this->addError("settings.$term.total", "CA + Exam must equal 100.");
        return;
    }

    ResultSetting::updateOrCreate(
        [
            'school_id' => $schoolId,
            'year_id'   => $this->selectedYearId,
            'term'      => $term,
        ],
        [
            'ca_total'   => $ca,
            'exam_total' => $exam,
        ]
    );

    session()->flash('status', ucfirst($term) . ' term settings saved!');
}

    public function render()
    {
        return view('livewire.admin.pages.school.result-settings-manager');
    }
}

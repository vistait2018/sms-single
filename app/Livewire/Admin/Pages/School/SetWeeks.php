<?php

namespace App\Livewire\Admin\Pages\School;

use Livewire\Component;
use App\Models\Week;
use App\Models\Year;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title("Set Weeks for a Term")]
class SetWeeks extends Component
{
    public $term = '';
    public $numberOfWeeks;
    public $activeYear;

    protected $rules = [
        'term' => 'required|in:first,second,third',
        'numberOfWeeks' => 'required|integer|min:1|max:52',
    ];

    protected $messages = [
        'term.required' => 'Please select a term.',
        'term.in' => 'Invalid term selected.',
        'numberOfWeeks.required' => 'Please enter number of weeks.',
        'numberOfWeeks.integer' => 'Weeks must be a number.',
        'numberOfWeeks.min' => 'At least 1 week is required.',
        'numberOfWeeks.max' => 'Maximum allowed weeks is 52.',
    ];

    public function mount()
    {
        $this->activeYear = Year::where('status', 'active')
            ->where('school_id', Auth::user()->school_id)
            ->first();
    }

    public function saveWeeks()
    {
        $this->validate();

        if (! $this->activeYear) {
            session()->flash('error', 'No active academic year found. Please set an active year first.');
            return;
        }

        $schoolId = Auth::user()->school_id;

        // create weeks 1..N if they don't exist
        for ($i = 1; $i <= (int)$this->numberOfWeeks; $i++) {
            Week::firstOrCreate([
                'number'    => $i,
                'school_id' => $schoolId,
                'term'      => $this->term,
                'year_id'   => $this->activeYear->id,
            ]);
        }

        session()->flash('success', ucfirst($this->term) . " term set to {$this->numberOfWeeks} week(s).");
        $this->reset(['term', 'numberOfWeeks']);
    }

    public function deleteWeek($weekId)
    {
        $week = Week::where('school_id', Auth::user()->school_id)->findOrFail($weekId);
        $week->delete();

        session()->flash('success', 'Week removed successfully.');
    }

    public function render()
    {
        $weeks = Week::where('school_id', Auth::user()->school_id)
            ->when($this->activeYear, fn($q) => $q->where('year_id', $this->activeYear->id))
            ->orderBy('term')
            ->orderBy('number')
            ->get()
            ->groupBy('term');

        return view('livewire.admin.pages.school.set-weeks', [
            'weeks' => $weeks,
            'activeYear' => $this->activeYear,
        ]);
    }
}

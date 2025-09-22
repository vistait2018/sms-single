<?php

namespace App\Livewire\Admin\Pages\School;

use App\Models\AttendanceWeek as Week;
use App\Models\Year;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;



#[Layout('layouts.app')]
#[Title("Set Attendace week session")]
class ManageWeeks extends Component
{

    use WithPagination;

    public $yearId;
    public $startDate;
    public $term;

    public function mount()
    {
        $year = Year::where('status', 'active')
            ->where('school_id', auth()->user()->school_id)
            ->first();
        $this->yearId = $year?->id;
        $this->term = $year?->term;
    }

public function generateWeeks()
{
    if (!$this->yearId || !$this->startDate) {
        return session()->flash('error', 'Select year and start date!');
    }

    // 🔹 Step 0: get the active year with its present term
    $year = Year::where('id', $this->yearId)
        ->where('status', 'active')
        ->first();

    if (!$year) {
        return session()->flash('error', 'No active academic year found!');
    }

    $this->term = $year->term; // ✅ enforce present term only

    // 🔹 Step 1: check if weeks already exist for this year + term
    $existingWeeks = Week::where('year_id', $this->yearId)
        ->where('school_id', auth()->user()->school_id)
        ->where('term', $this->term)
        ->exists();

    if ($existingWeeks) {
        return session()->flash(
            'error',
            "Weeks have already been generated for {$this->term} term ({$year->start_year}/{$year->end_year})"
        );
    }

    // 🔹 Step 2: deactivate ALL active weeks for this year
    Week::where('year_id', $this->yearId)
        ->where('school_id', auth()->user()->school_id)
        ->where('active', true)
        ->update(['active' => false]);

    // 🔹 Step 3: generate new 13 weeks
    $start = \Carbon\Carbon::parse($this->startDate);

    for ($i = 1; $i <= 13; $i++) {
        $weekStart = $start->copy()->addWeeks($i - 1)->startOfWeek(\Carbon\Carbon::MONDAY);
        $weekEnd   = $weekStart->copy()->addDays(4); // Friday

        Week::create([
            'year_id'    => $this->yearId,
            'number'     => $i,
            'start_date' => $weekStart,
            'end_date'   => $weekEnd,
            'school_id'  => auth()->user()->school_id,
            'term'       => $this->term,
            'active'     => true,
        ]);
    }

    session()->flash('status', "✅ Weeks generated successfully for {$this->term} term!");
}


public function render()
{
    $weeks = Week::where('year_id', $this->yearId)
        ->orderBy('number')
        ->paginate(10);

    $today = \Carbon\Carbon::today();

    // Add isCurrent flag for each week
    $weeks->getCollection()->transform(function ($week) use ($today) {
        $start = \Carbon\Carbon::parse($week->start_date);
        $end   = \Carbon\Carbon::parse($week->end_date);

        // ✅ Mark as current if today falls within the start/end date
        $week->isCurrent = $today->between($start, $end);

        return $week;
    });

    return view('livewire.admin.pages.school.manage-weeks', [
        'weeks' => $weeks,
        'years' => Year::all(),
    ]);
}


}

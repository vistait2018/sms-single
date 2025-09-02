<?php

namespace App\Livewire\Admin\Pages;

use App\Models\Year;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('School Session Manager')]
class YearManager extends Component
{
    use WithPagination;

    public $presentSession = null;
    public $search = '';
    public $showStartSession = false;

    public function mount()
    {
        $this->presentSession = Year::where('status', 'active')->first();
        $this->showStartSession = !$this->checkIfActiveSession();
    }

    private function checkIfActiveSession(): bool
    {
        $exist = Year::where('status', 'active')
            ->where('term', '<>', 'third')
            ->latest()
            ->first();

        return $exist !== null;
    }

   public function addYear()
{
    $yearVal = [
        'start_year' => date('Y'),
        'end_year'   => date('Y') + 1,
        'term'       => 'first',
        'status'     => 'active',
    ];

    try {
        $exist = Year::where('status', 'active')
            ->where('term', '<>', 'third')
            ->orWhere(function ($query) use ($yearVal) {
                $query->where('start_year', $yearVal['start_year'])
                      ->where('end_year', $yearVal['end_year']);
            })
            ->count();
            

        // Check if there's an existing active session OR duplicate years
        if ($exist > 0 ) {
            session()->flash('error', '❌ A session is still active. See a qualified admin.');
            return;
        }

        $this->presentSession = Year::create($yearVal);
        $this->showStartSession = false;

        session()->flash('status', '✅ New Session added successfully! We are now in First Term');
    } catch (\Exception $ex) {
        session()->flash('error', '❌ Session could not be added: ' . $ex->getMessage());
    }
}


    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function endCurrentTerm()
    {
        if (! $this->presentSession) return;

        if ($this->presentSession->term === 'first') {
            $this->presentSession->update(['term' => 'second']);
        } elseif ($this->presentSession->term === 'second') {
            $this->presentSession->update(['term' => 'third']);
        } elseif ($this->presentSession->term === 'third') {
            $this->presentSession->update(['status' => 'inactive']);
            $this->showStartSession = true;
           
        }

         setSchoolSession();
        $this->presentSession->refresh();
    }

   
    public function render()
    {
        return view('livewire.admin.pages.year-manager', [
            'years' => Year::when($this->search, function ($query) {
                $query->where('start_year', 'like', '%' . $this->search . '%')
                      ->orWhere('end_year', 'like', '%' . $this->search . '%');
            })->paginate(10),
        ]);
    }
}

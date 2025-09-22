<?php

namespace App\Livewire\Admin\Pages\School;

use App\Models\Salary;
use App\Models\Teacher;
use App\Models\Year;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Barryvdh\DomPDF\Facade\Pdf;
use Symfony\Component\HttpFoundation\Response;

#[Layout('layouts.app')]
#[Title("Teacher's Salary")]
class TeacherSalary extends Component
{
    public $search;
    public $teacher_id;
    public $amount;
    public $updatedTeacherId = null;
    public $byAmount = false;
    public $byPercentage = false;
    public $selectedType = null;
    public $selectedPercentage;
    public $amountToIncreaseWith;
    public $type;

    public function edit($teacher_id)
    {
        $this->teacher_id = $teacher_id;
        $this->dispatch('open-modal', 'editSalary');
    }

    public function updatedSelectedType($type)
    {
        if ($type === 'amount') {
            $this->byAmount = true;
            $this->byPercentage = false;
            $this->type = 'amount';
        } elseif ($type === 'percentage') {
            $this->byPercentage = true;
            $this->byAmount = false;
            $this->type = 'percentage';
        }
    }

    public function openSalaryIncreaseModal()
    {
        $this->dispatch('open-modal', 'increaseSalary');
    }

  public function increaseSalaryForm()
{
    $year_id = Year::where('status', 'active')
        ->where('school_id', Auth::user()->school_id)
        ->first()?->id;

    // Only teachers with an active salary
    $teachers = Teacher::where('school_id', Auth::user()->school_id)
        ->whereHas('activeSalary') // ✅ ensures active salary exists
        ->with('activeSalary')
        ->get();

    foreach ($teachers as $teacher) {
        $currentSalary = $teacher->activeSalary?->amount;

        if (!$currentSalary) {
            continue; // skip if somehow no active salary
        }

        if ($this->type === 'amount' && $this->amountToIncreaseWith) {
            $newSalary = $currentSalary + $this->amountToIncreaseWith;
        } elseif ($this->type === 'percentage' && $this->selectedPercentage) {
            $increase = $this->calculateAmount($this->selectedPercentage, $currentSalary);
            $newSalary = $currentSalary + $increase;
        } else {
            continue;
        }

        // deactivate current salary
        $teacher->activeSalary->update(['active' => false]);

        // insert new salary
        Salary::create([
            'teacher_id' => $teacher->id,
            'amount'     => $newSalary,
            'active'     => true,
            'year_id'    => $year_id,
        ]);
    }

    $this->dispatch('close-modal', 'increaseSalary');
    session()->flash('status', 'All active teachers salaries updated successfully!');
}


    private function calculateAmount($percentage, $salary)
    {
        return ($percentage * $salary) / 100;
    }

    public function closeModal()
    {
        $this->teacher_id = null;
        $this->dispatch('close-modal', 'editSalary');
       

    }

    public function downloadTeacherSalariePDF()
{
    $teachers = Teacher::where('school_id', Auth::user()->school_id)
        ->whereHas('activeSalary')
        ->with('activeSalary')
        ->orderBy('last_name')
        ->get();

    $data = [
        'teachers' => $teachers,
        'school'   => Auth::user()->school->school_name ?? 'My School',
        'date'     => now()->format('F j, Y'),
    ];

    $pdf = Pdf::loadView('pdf.teacher-salaries', $data)->setPaper('a4', 'portrait');

    return response()->streamDownload(function () use ($pdf) {
        echo $pdf->output();
    }, 'teacher_salaries.pdf');
}
    public function closeIncreaseSalaryModal(){
        $this->type = null;
        $this->byAmount = false;
        $this->byPercentage = false;
        $this->amountToIncreaseWith = null;
        $this->selectedPercentage = null;
      $this->dispatch('close-modal', 'increaseSalary');  
    }

    public function updateTeacher()
    {
        $this->validate([
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        $salaryExist = Salary::where('teacher_id', $this->teacher_id)
            ->where('active', true)
            ->first();

        if ($salaryExist) {
            $salaryExist->update(['active' => false]);
        }

        $year_id = Year::where('status', 'active')
            ->where('school_id', Auth::user()->school_id)
            ->first()?->id;

        Salary::create([
            'teacher_id' => $this->teacher_id,
            'amount'     => $this->amount,
            'active'     => true,
            'year_id'    => $year_id,
        ]);

        $this->updatedTeacherId = $this->teacher_id;
        $this->closeModal();

        session()->flash('status', 'Teacher Salary updated successfully!');
    }

    public function render()
    {
        $teachers = Teacher::where('school_id', Auth::user()->school_id)
            ->when($this->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('sex', 'like', "%{$search}%");
                });
            })
            ->with('salaries')
            ->with('activeSalary')
            ->latest()
            ->paginate(12);

        return view('livewire.admin.pages.school.teacher-salary', [
            'teachers' => $teachers,
        ]);
    }
}

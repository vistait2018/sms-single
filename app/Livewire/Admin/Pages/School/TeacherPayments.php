<?php

namespace App\Livewire\Admin\Pages\School;

use App\Models\Teacher;
use App\Models\TeacherPayment;
use App\Models\Year;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('layouts.app')]
#[Title("Teacher's Payments")]
class TeacherPayments extends Component
{
    use WithPagination;

    public $search;
    public $selectedTeacher = null;

    public function selectTeacher($teacherId)
    {
        $this->selectedTeacher = $this->selectedTeacher === $teacherId ? null : $teacherId;
    }

   public function payTeacher($teacherId)
{
    $teacher = Teacher::with('activeSalary')->findOrFail($teacherId);

    if (! $teacher->activeSalary) {
        session()->flash('error', 'This teacher has no active salary assigned.');
        return;
    }

    $now = Carbon::now();
    $year_id  = Year::where('status', 'active')
    ->where('school_id',Auth::user()->school_id)
        ->first()?->id;
    $month = $now->format('F'); // e.g. "September"

    // 🔎 Prevent duplicate payment for the same month/year
    $alreadyPaid = TeacherPayment::where('teacher_id', $teacher->id)
        ->where('year_id', $year_id)
        ->where('month', $month)
        ->where('status', 'paid')
        ->exists();

    if ($alreadyPaid) {
        session()->flash('error', 'This teacher has already been paid for ' . $month . ' ' . $year);
        return;
    }

    // 💰 Create payment record
    \App\Models\TeacherPayment::create([
        'teacher_id'  => $teacher->id,
        'paid_by'     => Auth::id(),
        'amount'      => $teacher->activeSalary->amount,
        'year_id'     => $year_id,
        'month'       => $month,
        'description' => 'Salary payment for ' . $month . ' ' . Date('Y'),
        'status'      => 'paid',
    ]);

    session()->flash('status', 'Payment recorded successfully for ' . $teacher->first_name);
}

    public function render()
    {
        $teachers = \App\Models\Teacher::where('school_id', Auth::user()->school_id)
            ->when($this->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('middle_name', 'like', "%{$search}%")
                        ->orWhere('sex', 'like', "%{$search}%");
                });
            })
            ->with(['activeSalary', 'payments' => fn($q) => $q->latest()])
            ->paginate(12);

        return view('livewire.admin.pages.school.teacher-payments', [
            'teachers' => $teachers,
        ]);
    }
}

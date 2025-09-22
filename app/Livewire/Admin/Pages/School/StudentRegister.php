<?php

namespace App\Livewire\Admin\Pages\School;

use App\Models\Level;
use App\Models\DepartmentLevel;

use Livewire\Component;
use App\Services\RegisterStudentService;
use App\Models\Student;
use App\Models\User;
use App\Models\Year;
use App\Notifications\OTPNotification;
use App\Services\GenerateUserService;
use App\Services\OtpService;

use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;


#[Layout('layouts.app')]
#[Title('School Student Registration')]
class StudentRegister extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $first_name, $middle_name, $last_name, $sex = null ;
    public $phone_no, $address, $dob, $state_id, $lga_id;
    public $religion, $nationality, $state_of_origin;

    public $search = '';
    public $edit = false;
    public $showStudentForm = false;
    public $selectedStudent = null;
    public $selectLevel = null;
    public $selectedReligion = null;
    public $selectedState = null;
    public $selectedLga = null;
    public $lgas = [];
    public $level;
    public $activateUser = false;
    public $UserEditId = null;
    public $studentId;
    public $email;
    public $avatar;    // for new student
    public $avatars = []; // for updating existing student avatars
    public $states = [];
    private function resetStudentForm()
    {
        $this->reset([
            'first_name',
            'middle_name',
            'last_name',
            'sex',
            'phone_no',
            'address',
            'dob',
            'religion',
            'selectedReligion',
            'nationality',
            'selectedState',
            'selectedLga',
            'selectLevel',
            'lgas',
            'sex',

        ]);
    }


    public function mount()
    {
        $this->states = \App\Models\State::all();

        //$this->lgas   = \App\Models\Lga::all(); // load all LGAs once
    }
    public function updatedSelectedState($stateId)
    {


        $this->lgas = \App\Models\Lga::where('state_id', $stateId)
            ->get(['id', 'name']);
        $this->state_id = $stateId;



        $this->selectedLga = null;
    }
    public function addUser(int $student_id)
    {
        $this->studentId = $student_id;
        $student = Student::findOrFail($this->studentId);

        // If the student has no linked user → open modal
        if (!$student->user_id) {
            $this->dispatch('open-modal', 'addUser');
            return;
        }

        $user = User::findOrFail($student->user_id);

        // If the linked user has no email → open modal
        if (empty($user->email)) {
            $this->dispatch('open-modal', 'addUser');
            return;
        }

        // If the user exists and has an email → activate user
        $user->update(['is_activated' => true]);
    }


    public function notifyUser(GenerateUserService $generalUserService)
    {
        $student = Student::findOrFail($this->studentId);



        // Validate a new email from the modal input
        $validated = $this->validate([
            'email' => 'required|email|unique:users,email',
        ]);
        $this->email = $validated['email'];


        $validMinutes = 10;

        // If student has no user, create one
        if (!$student->user_id) {
            $name = $student->last_name . ' ' . $student->first_name;
            $user = $generalUserService::createUser($name, $this->email, $student->id, 'student');

            $user->update(['is_activated' => false]);
            $student->update(['user_id' => $user->id]);
        }

        // Generate OTP and send notification
        // $otpCode = $otpService->generateOtpCode($user->id, $validMinutes);
        //$user->notify(new OTPNotification($user, $otpCode, $validMinutes));

        session()->flash('success', 'OTP has been sent to the user.');
    }


    public function toggleStudentform()
    {
        $this->showStudentForm = !$this->showStudentForm;

    // Now that we're switching to the form, clear any stale values
    if ($this->showStudentForm) {
        $this->resetStudentForm();
        $this->resetValidation();
    }
    }

    public function removeUser($student_id, GenerateUserService $generalUserService)
    {

        $user =  $generalUserService::deActivateUser($student_id);
    }
    public function updatedSelectedLga($lga_id)
    {
        $this->selectedLga = $lga_id;
        $this->lga_id = $lga_id;
    }

    public function updatedSelectLevel($level_id)
    {
        $this->selectLevel = $level_id;
    }

    public function updatedSelectedReligion($religion)
    {
        $this->religion = $religion;
    }

    /**
     * Upload/replace student avatar
     */
    public function updatedAvatars($file, $studentId)
    {
        $this->validate([
            "avatars.$studentId" => 'image|max:2048',
        ]);

        $student = Student::findOrFail($studentId);

        // Delete old avatar if exists
        if ($student->avatar && Storage::disk('public')->exists($student->avatar)) {
            Storage::disk('public')->delete($student->avatar);
        }

        // Save new avatar
        $filename = uniqid() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('avatars/students', $filename, 'public');

        $student->update(['avatar' => $path]);

        unset($this->avatars[$studentId]);
        session()->flash('message', 'Avatar updated successfully!');
    }

    /**
     * Register a new student
     */

    public function updatedSearch()
{
    $this->resetPage();
}
    public function registerStudent(RegisterStudentService $service)
    {

        $this->validate([
            'first_name'   => 'required',
            'last_name'    => 'required',
            'sex'          => 'required|in:male,female',
            'avatar'       => 'nullable|image|max:2048',
            'selectLevel'  => 'required|exists:levels,id',
            'phone_no'   => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:500',
            'dob'        => 'nullable|date',
            'selectedReligion'   => 'nullable|string|max:100',
            'selectedState' => 'nullable|exists:states,id', // Add validation for state
            'selectedLga'   => 'nullable|exists:lgas,id',   // Add validation
        ]);

        try {
            DB::transaction(function () use ($service) {
                $student = $service->register([
                    'first_name'  => $this->first_name,
                    'middle_name' => $this->middle_name,
                    'last_name'   => $this->last_name,
                    'sex'         => $this->sex,
                    'school_id'   => Auth::user()->school_id,
                    'phone_no'   => $this->phone_no,
                    'address'    => $this->address,
                    'dob'        => $this->dob,
                    'religion'   => $this->selectedReligion,
                    'state_id'   => $this->selectedState,
                    'lga_id'     => $this->selectedLga,
                ]);

                if ($this->avatar) {
                    $path = $this->avatar->store('avatars/students', 'public');
                    $student->update(['avatar' => $path]);
                }

                if ($student) {
                    $year = Year::where('status', 'active')->first();

                    $departmentLevel = DepartmentLevel::where('level_id', $this->selectLevel)
                        ->where('active', true)
                        ->first();

                    $oldDepartmentLevels = $student->levels()
                        ->wherePivot('year_id', $year?->id)
                        ->wherePivot('active', true)
                        ->get();

                    foreach ($oldDepartmentLevels as $oldDepartmentLevel) {
                        $oldDepartmentLevel->pivot->update(['active' => false]);
                    }

                    $student->levels()->attach(
                        $this->selectLevel,
                        [
                            'year_id'       => $year?->id,
                            'department_id' => $departmentLevel?->department_id,
                            'active'        => true,
                        ]
                    );
                }
            });

            $this->resetExcept(['states', 'search']);
            $this->sex = null;
            $this->selectLevel = null;
            $this->selectedReligion = null;
            $this->lgas = [];


            $this->dispatch('saved');
        } catch (\Exception $ex) {
            session()->flash('error', "An error occurred: " . $ex->getMessage());
        }
    }

    /**
     * Open modal to view/edit student
     */
    public function viewStudent($id)
    {

        $this->selectedStudent = Student::with(['levels'])->findOrFail($id);
        $this->selectedStudent = Student::findOrFail($id);

        $this->first_name   = $this->selectedStudent->first_name;
        $this->middle_name  = $this->selectedStudent->middle_name;
        $this->last_name    = $this->selectedStudent->last_name;
        $this->sex          = $this->selectedStudent->sex;
        $this->phone_no     = $this->selectedStudent->phone_no;
        $this->address      = $this->selectedStudent->address;
        $this->dob          = $this->selectedStudent->dob;
        $this->religion     = $this->selectedStudent->religion;
        $this->nationality  = $this->selectedStudent->nationality;

        // ✅ load state and LGA IDs from student
        $this->selectedState = $this->selectedStudent->state_id;
        $this->selectedLga   = $this->selectedStudent->lga_id;

        $this->level = $this->selectedStudent->levels()->first()?->name ?? '---';

        // ✅ Crucial: Populate LGAs based on the selected student's state
        if ($this->selectedState) {
            $this->lgas = \App\Models\Lga::where('state_id', $this->selectedState)->get();
        } else {
            $this->lgas = []; // Clear LGAs if no state is selected for the student
        }

        $this->dispatch('open-modal', 'editStudent');
    }

    public function showRegistrationForm()
    {
        $this->resetStudentForm();
        $this->showStudentForm = true;
    }

    public function closeStudentModal()
    {
        $this->reset([
            'selectedStudent',
            'first_name',
            'middle_name',
            'last_name',
            'sex',
            'phone_no',
            'address',
            'dob',
            'religion',
            'selectedReligion',
            'nationality',
            'selectedState',
            'selectedLga',
            'selectLevel',
            'level',
            'lgas',
            'edit'
        ]);

        $this->dispatch('close-modal', 'editStudent');
    }

    /**
     * Update student info
     */
    public function updateStudent()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'sex'        => 'required|in:male,female',
            'phone_no'   => 'nullable|string|max:20',
            'address'    => 'nullable|string|max:500',
            'dob'        => 'nullable|date',
            'selectedReligion'   => 'nullable|string|max:100',
            'selectedState' => 'nullable|exists:states,id', // Add validation for state
            'selectedLga'   => 'nullable|exists:lgas,id',   // Add validation
        ]);

        if ($this->selectedStudent) {
            $this->selectedStudent->update([
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name'  => $this->last_name,
                'sex'        => $this->sex,
                'phone_no'   => $this->phone_no,
                'address'    => $this->address,
                'dob'        => $this->dob,
                'religion'   => $this->religion,
                'nationality' => $this->nationality,
                'state_id'   => $this->selectedState,
                'lga_id'     => $this->selectedLga,
            ]);
        }

        if ($this->selectedStudent) {
            $this->selectedStudent->update([

                'state_id'   => $this->selectedState,
                'lga_id'     => $this->selectedLga,
            ]);
        }
        session()->flash('success', 'Student updated successfully!');
        $this->edit = false;

        $this->closeStudentModal();
    }

    public function render()
    {
       $students = Student::with('levels', 'user')
    ->where('school_id', Auth::user()->school_id)
    ->when($this->search, function ($query) {
        $query->where(function ($q) {
            $q->where('first_name', 'like', "%{$this->search}%")
              ->orWhere('last_name', 'like', "%{$this->search}%")
              ->orWhere('sex', 'like', "%{$this->search}%")
              ->orWhereHas('levels', function ($levelQuery) {
                  $levelQuery->where('name', 'like', "%{$this->search}%");
              });
        });
    })
    ->latest()
    ->paginate(9);


    return view('livewire.admin.pages.school.student-register', [
        'students' => $students,
        'levels'   => Level::where('school_id', Auth::user()->school_id)->get(),
    ]);

    }
}

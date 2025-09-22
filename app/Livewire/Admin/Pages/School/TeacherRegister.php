<?php

namespace App\Livewire\Admin\Pages\School;

use App\Models\Lga;
use App\Models\State;
use Livewire\Component;
use App\Services\RegisterTeacherService;
use App\Models\Teacher;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('School Teacher Registration')]
class TeacherRegister extends Component
{

    use WithFileUploads;
    use WithPagination;
    public $first_name, $middle_name, $last_name, $sex, $email, $password;
    public $phone_no, $address, $qualification, $details, $date_of_employment, $dob;
    public $religion, $nationality, $state_of_origin, $lga;

    public $search = '';
    public $edit = false;
    public $generatedPassword;
    public $showTeacherForm = false;
    public $selectedTeacher = null;
    public $selectedState = null;
    public $selectedLga = null;
    public $states = null;
    public $lgas = [];
    public $state_id;
    public $lga_id;

    public $avatar;   // for new teacher registration
    public $avatars = []; // for updating existing teacher avatars
    public $signatures = [];

    public function mount()
    {

        $this->states = \App\Models\State::all();

        //$this->lgas   = \App\Models\Lga::all(); // load all LGAs once
    }

    public function updatedSignatures($file, $teacherId)
    {
        $this->validate([
            "signatures.$teacherId" => 'image|max:2048', // only images, max 2MB
        ]);

        $teacher = Teacher::findOrFail($teacherId);

        // Delete old signature if it exists
        if ($teacher->sign_url && Storage::disk('public')->exists($teacher->sign_url)) {
            Storage::disk('public')->delete($teacher->sign_url);
        }

        // Save new signature
        $filename = uniqid() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('sign', $filename, 'public'); // stored in storage/app/public/sign

        // Update teacher record
        $teacher->update(['sign_url' => $path]);

        // Reset temporary file
        unset($this->signatures[$teacherId]);

        session()->flash('message', 'Signature updated successfully!');
    }
    public function updateSelectedLga($lga_id)
    {
        $this->lga_id = $lga_id;
    }
    public function updatedSelectedState($stateId)
    {
        $this->lgas = \App\Models\Lga::where('state_id', $stateId)
            ->get(['id', 'name']);
        $this->state_id = $stateId;

        $this->selectedLga = null;
    }
    public function generatePassword()
    {
        $this->generatedPassword = Str::random(10);
        $this->password = $this->generatedPassword;
    }

    public function updatedAvatars($file, $teacherId)
    {
        $this->validate([
            "avatars.$teacherId" => 'image|max:2048',
        ]);

        $teacher = Teacher::with('user')->findOrFail($teacherId);
        $user = $teacher->user;

        if (!$user) {
            session()->flash('message', 'Cannot update avatar: user account not found.');
            unset($this->avatars[$teacherId]);
            return;
        }

        // Delete old avatar if exists
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar to the correct folder
        $filename = uniqid() . '_' . $file->getClientOriginalName();

        // Final path: storage/app/public/avatars/teachers/<filename>

        $path = $file->storeAs('avatars/teachers', $filename, 'public');

        // Update user record with the new relative path
        $user->update(['avatar' => $path]);

        // Clear temp upload
        unset($this->avatars[$teacherId]);

        session()->flash('message', 'Avatar updated successfully!');
    }

    public function registerTeacher(RegisterTeacherService $service)
    {

        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'sex' => 'required|in:male,female',
            'email' => 'required|email|unique:users,email' . ($this->selectedTeacher ? ',' . $this->selectedTeacher->user_id : ''),
            'phone_no' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'qualification' => 'nullable|string|max:255',
            'date_of_employment' => 'nullable|date',
            'dob' => 'nullable|date',
            'religion' => 'nullable|string|max:100',
            'selectedLga' => 'nullable|string|max:100',
            'selectedState' => 'nullable|string|max:100',
            'details' => 'nullable|string|max:100',
        ]);

        $lga = Lga::findOrFail($this->selectedLga);
        $state_of_origin = State::findOrFail($this->selectedState);
        $teacher = $service->register([
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone_no' => $this->phone_no,
            'address' => $this->address,
            'qualification' => $this->qualification,
            'details' => $this->details,
            'date_of_employment' => $this->date_of_employment,
            'dob' => $this->dob,
            'religion' => $this->religion,
            'state_of_origin' => $state_of_origin->name,
            'lga' => $lga->name,
            'password' => $this->generatePassword() ?? 'password123456',
            'school_id' => Auth::user()->school_id,
            'sex' => $this->sex,
        ]);

        if ($this->avatar) {

            $path = $this->avatar->store('avatars/teachers', 'public');
            if ($teacher->user) {
                $teacher->user->update(['avatar' => $path]);
            }
        }

        $this->reset([
            'first_name',
            'middle_name',
            'last_name',
            'sex',
            'email',
            'password',
            'avatar',
            'date_of_employment',
            'dob',
            'religion',
            'qualification',
            'details',
            'address',
            'phone_no'
        ]);
        $this->dispatch('saved');
    }

    public function viewTeacher($id)
    {
        $this->selectedTeacher = Teacher::with('user')->findOrFail($id);

        $this->first_name = $this->selectedTeacher->first_name;
        $this->middle_name = $this->selectedTeacher->middle_name;
        $this->last_name = $this->selectedTeacher->last_name;
        $this->sex = $this->selectedTeacher->sex;
        $this->phone_no = $this->selectedTeacher->phone_no;
        $this->address = $this->selectedTeacher->address;
        $this->qualification = $this->selectedTeacher->qualification;
        $this->date_of_employment = $this->selectedTeacher->date_of_employment;
        $this->dob = $this->selectedTeacher->dob;
        $this->details = $this->selectedTeacher->details;

        $this->religion = $this->selectedTeacher->religion;
        $this->nationality = $this->selectedTeacher->nationality;
        $this->state_of_origin = $this->selectedTeacher->state_of_origin;
        $this->email = $this->selectedTeacher->user->email ?? null;

        $this->dispatch('open-modal', 'editTeacher');
    }

    public function closeTeacherModal()
    {
        $this->reset([
            'selectedTeacher',
            'first_name',
            'middle_name',
            'last_name',
            'sex',
            'email',
            'phone_no',
            'address',
            'qualification',
            'date_of_employment',
            'dob',
            'religion',
            'nationality',
            'state_of_origin',
            'edit'
        ]);

        $this->dispatch('close-modal', 'editTeacher');
    }

    public function updateTeacher()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'sex' => 'required|in:male,female',
            'phone_no' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'qualification' => 'nullable|string|max:255',
            'date_of_employment' => 'nullable|date',
            'dob' => 'nullable|date',
            'religion' => 'nullable|string|max:100',
            'selectedLga' => 'nullable|string|max:100',
            'selectedState' => 'nullable|string|max:100',
            'details' => 'nullable|string|max:100',
            'email' => 'required|email|unique:users,email,' . $this->selectedTeacher->user_id,

        ]);

        $this->selectedTeacher->update([
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'sex' => $this->sex,
            'phone_no' => $this->phone_no,
            'address' => $this->address,
            'qualification' => $this->qualification,
            'date_of_employment' => $this->date_of_employment,
            'dob' => $this->dob,
            'religion' => $this->religion,
            'nationality' => $this->nationality,
            'state_of_origin' => $this->state_of_origin,
        ]);

        if ($this->selectedTeacher->user) {
            $this->selectedTeacher->user->update(['email' => $this->email]);
        }

        session()->flash('success', 'Teacher updated successfully!');
        $this->dispatch('close-modal', 'editTeacher');
    }
public function updatedSearch()
{
    $this->resetPage();
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
    ->latest()
    ->paginate(12);


        return view('livewire.admin.pages.school.teacher-register', [
            'teachers' => $teachers,
        ]);
    }
}

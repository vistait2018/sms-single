<?php

namespace App\Livewire\Admin\Pages\School;

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
    public $phone_no, $address, $qualification, $date_of_employment, $dob;
    public $religion, $nationality, $state_of_origin;

    public $search = '';
    public $edit = false;
    public $generatedPassword;
    public $showTeacherForm = false;
    public $selectedTeacher = null;

    public $avatar;   // for new teacher registration
    public $avatars = []; // for updating existing teacher avatars

    

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
    $filename = uniqid().'_'.$file->getClientOriginalName();

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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email',
            'avatar' => 'nullable|image|max:2048',
            'sex'        => 'required|in:male,female',
        ]);

        $teacher = $service->register([
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => $this->generatePassword() ?? 'password123456',
            'school_id' => Auth::user()->school_id,
            'sex'=>$this->sex,
        ]);
  
        if ($this->avatar) {
          
            $path = $this->avatar->store('avatars/teachers', 'public');
            if ($teacher->user) {
                $teacher->user->update(['avatar' => $path]);
            }
        }

        $this->reset(['first_name','middle_name','last_name','sex','email','password','avatar']);
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
        $this->religion = $this->selectedTeacher->religion;
        $this->nationality = $this->selectedTeacher->nationality;
        $this->state_of_origin = $this->selectedTeacher->state_of_origin;
        $this->email = $this->selectedTeacher->user->email ?? null;

        $this->dispatch('open-modal', 'editTeacher');
    }

    public function closeTeacherModal()
    {
        $this->reset([
            'selectedTeacher','first_name','middle_name','last_name','sex','email',
            'phone_no','address','qualification','date_of_employment','dob',
            'religion','nationality','state_of_origin','edit'
        ]);

        $this->dispatch('close-modal', 'editTeacher');
    }

    public function updateTeacher()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'sex' => 'required|in:male,female',
            'email' => 'required|email|unique:users,email,' . $this->selectedTeacher->user_id,
            'phone_no' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'qualification' => 'nullable|string|max:255',
            'date_of_employment' => 'nullable|date',
            'dob' => 'nullable|date',
            'religion' => 'nullable|string|max:100',
            'nationality' => 'nullable|string|max:100',
            'state_of_origin' => 'nullable|string|max:100',
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

    public function render()
    {
        $teachers = Teacher::where('school_id', Auth::user()->school_id)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('first_name', 'like', "%{$this->search}%")
                      ->orWhere('last_name', 'like', "%{$this->search}%")
                      ->orWhere('sex', 'like', "%{$this->search}%");
                });
            })
            ->latest()
            ->paginate(5);

        return view('livewire.admin.pages.school.teacher-register', [
            'teachers' => $teachers,
        ]);
    }
}

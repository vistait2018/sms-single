<?php

namespace App\Livewire\Admin\Pages;

use App\Helpers\RoleHelper;
use App\Models\School;
use App\Models\teacher;
use App\Models\User;
use App\Notifications\WelcomeUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

#[Layout('layouts.app')]
#[Title('Admin Schools')]
class Schools extends Component
{
    use WithFileUploads;

    public $search = '';
    public $logo;
    public $editingSchoolId;
    public $editLogo = false;
    public $editing = false;
    public $school;

    // Form fields
    public $school_name, $address, $phone_no, $email, $type, $date_of_establishment , $proprietor;
    public $admin_email, $first_name, $last_name, $sex;



    /**
     * Custom validation messages
     */
    protected $messages = [
        'school_name.required'            => 'School name is required.',
        'address.required'                => 'Address is required.',
        'phone_no.required'               => 'Phone number is required.',
        'phone_no.digits_between' => 'Phone number must not be more than 11 digits.',
        'email.required'                  => 'Email is required.',
        'email.email'                     => 'Please enter a valid email address.',
        'email.unique'                     => 'This email is already taken.',
        'type.required'                   => 'School type is required.',
        'type.in'                         => 'Type must be either Primary or Secondary.',
        'date_of_establishment.required'  => 'Date of establishment is required.',
        'date_of_establishment.date'      => 'Date of establishment must be a valid date.',
        'date_of_establishment.before'    => 'The date of establishment must be before today.',
        'proprietor.required'             => 'Proprietor name is required.',
    ];

    public function addSchool()
    {

        $validated = $this->validate([
            'school_name'           => 'required|string|max:255',
            'address'               => 'required|string|max:255',
            'phone_no'              => 'required|digits:11',
            'email'                 => 'required|email|unique:schools,email',
            'type'                  => 'required|in:primary,secondary',
            'date_of_establishment' => 'required|date|before:today',
            'proprietor'            => 'required|string|max:255',

            'admin_email'           => 'required|email|unique:users,email',
            'first_name'            => 'required|string|max:255',
            'last_name'             => 'required|string|max:255',
            'sex'                   => 'required|in:male,female,other',
        ]);

        // Prepare arrays
        $schoolInfo = [
            'school_name'           => $validated['school_name'],
            'address'               => $validated['address'],
            'phone_no'              => $validated['phone_no'],
            'email'                 => $validated['email'],
            'type'                  => $validated['type'],
            'date_of_establishment' => $validated['date_of_establishment'],
            'proprietor'            => $validated['proprietor'],
        ];

        $plainPassword = $this->getRandomPassword();

        $userInfo = [
            'email'    => $validated['admin_email'],
            'password' => Hash::make($plainPassword),
        ];

        $teacherInfo = [
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'sex'        => $validated['sex'],
        ];

        try {
            DB::beginTransaction();

            // Create school
            $school = School::create($schoolInfo);


            // Create user
            $userInfo['school_id'] = $school->id;
            $user = User::create($userInfo);

            //Admin School Admin Role
            RoleHelper::assignRole($user, 'school_admin');

            // Create teacher
            $teacherInfo['user_id'] = $user->id;
            $teacherInfo['school_id'] = $school->id;
            Teacher::create($teacherInfo);

            // Send welcome notification (include password)
            $user->notify(new WelcomeUser($user, $plainPassword));

            DB::commit();

           $this->reset(['school_name', 'address', 'phone_no', 'email', 'type', 'date_of_establishment', 'proprietor', 'admin_email', 'first_name', 'last_name', 'sex']);

            $this->dispatch('close-modal', 'addSchool');
            session()->flash('status', '✅ School added successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', '❌ Something went wrong: ' . $e->getMessage());
        }
    }

    public function lockSchool($schoolId){
       // dd($schoolId);
        $school = School::findOrFail($schoolId);
        $school->is_locked = true;
        $school->save();
    }

     public function unlockSchool($schoolId){
        $school = School::findOrFail($schoolId);
         $school->is_locked = false;
        $school->save();
    }

    public function updateLogo($schoolId)
    {
        $this->validate([
            'logo' => 'required|image|max:2048', // 2MB limit
        ]);

        $school = School::findOrFail($schoolId);

        // delete old logo if exists
        if ($school->school_logo && Storage::disk('public')->exists('logos/' . $school->school_logo)) {
            Storage::disk('public')->delete('logos/' . $school->school_logo);
        }

        // store new logo
        $path = $this->logo->store('logos', 'public');
        $school->school_logo = $path;
        $school->save();

        // reset
        $this->reset(['logo', 'editingSchoolId']);
        session()->flash('status', 'School logo updated successfully!');
    }

    public function showLogoEditor($schoolId)
    {
        $this->editingSchoolId = $schoolId;
        $this->editLogo = !$this->editLogo;
    }

    public function mount(School $school)
    {
        $this->date_of_establishment = optional($school->date_of_establishment)->format('Y-m-d');
    }

    private function getRandomPassword(int $length = 12): string
    {
        return Str::random($length);
    }

    public function showeditForm($schoolId)
    {
        $school = School::findOrFail($schoolId);


       // dd($school->date_of_establishment)->format('Y-m-d');
        $this->editingSchoolId     = $school->id;
        $this->school_name         = $school->school_name;
        $this->address             = $school->address;
        $this->phone_no            = $school->phone_no;
        $this->email               = $school->email;
        $this->type                = $school->type;
        $this->date_of_establishment = $school->date_of_establishment
                ? \Carbon\Carbon::parse($school->date_of_establishment)->format('Y-m-d')
                : null;
        $this->proprietor          = $school->proprietor;

        $this->dispatch('open-modal', 'editSchool');
    }

    public function updateSchool()
    {
        $validated = $this->validate([
            'school_name'           => 'required|string|max:255',
            'address'               => 'required|string|max:255',
            'phone_no'              => 'required|digits:11',
            'email'                 => [
                'required',
                'email',
                Rule::unique('schools', 'email')->ignore($this->editingSchoolId),
            ],
            'type'                  => 'required|in:primary,secondary',
            'date_of_establishment' => 'required|date|before:today',
            'proprietor'            => 'required|string|max:255',
        ]);

        try {
            $school = School::findOrFail($this->editingSchoolId);

            $school->update($validated);

            $this->reset(['school_name', 'address', 'phone_no', 'email', 'type', 'date_of_establishment', 'proprietor', 'editingSchoolId', 'editing']);
            $this->dispatch('close-modal', 'editSchool');

            session()->flash('status', '✅ School updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', '❌ Update failed: ' . $e->getMessage());
        }
    }
    public function render()
    {
        $schools = School::query();

        if ($this->search) {
            $schools = $schools->where('email', 'like', '%' . $this->search . '%')
                ->orWhere('school_name', 'like', '%' . $this->search . '%')
                ->orWhere('type', 'like', '%' . $this->search . '%')
                ->paginate(10);
        } else {
            $schools = School::latest()->paginate(12);
        }

        return view('livewire.admin.pages.schools', compact('schools'));
    }
}

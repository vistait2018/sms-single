<?php

namespace App\Livewire\Admin\Pages;

use App\Helpers\RoleHelper;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Guardian;
use App\Models\School;
use App\Notifications\WelcomeUser;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
use InvalidArgumentException;


#[Layout('layouts.app')]
#[Title('Admin Users')]
class Users extends Component
{
    public $search = '';
    public $first_name;
    public $last_name;
    public $middle_name;
    public $email;
    public $type;
    public $sex;
    public $schoolSearch = '';
    public $school_id = null;
    public $schools = [];

    public function rules()
    {
        return [
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'middle_name'  => 'nullable|string|max:255',
            'sex'          => 'required|string|in:male,female',
            'email'        => 'required|email|unique:users,email',
            'type'         => 'required|in:student,teacher,guardian',
            'school_id'    => 'required|exists:schools,id'
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First name is required.',
            'last_name.required'  => 'Last name is required.',
            'email.required'      => 'Email is required.',
            'email.email'         => 'Enter a valid email address.',
            'email.unique'        => 'This email is already taken.',
            'type.required'       => 'Type is required.',
            'type.in'             => 'Type must be either student, teacher, or guardian.',
            'sex.required'        => 'Sex is required.',
            'sex.in'              => 'Sex must be either male or female.',
            'school_id.required'  => 'School is required.',
            'school_id.exists'    => 'Selected school is invalid.'
        ];
    }

    public function mount()
    {
       // getSuperAdminPrivileges();
        $this->schools = School::limit(10)->get();
    }

    public function createUser()
{
    try {
        DB::beginTransaction();
        $validated = $this->validate();
        $validated['type'] = 'teacher';
        $temporaryPassword = Str::random(12);

        $userPayload = [
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($temporaryPassword),
            'school_id' => $validated['school_id'],
        ];

        $profilePayload = [
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'sex'        => $validated['sex'],
            'school_id'  => $validated['school_id'],
        ];

        $userRecord = User::query()->create($userPayload);
         RoleHelper::assignRole($userRecord, 'school_admin');
        //$tempPass = $this->setTemporaryPassword($userRecord);

        if (!$userRecord) {
            throw new \Exception('Failed to create user.');
        }

        $modelClass = $this->getModelByType($validated['type']);
        (new $modelClass)->query()->create($profilePayload);


        $userRecord->notify(new WelcomeUser($userRecord));
                DB::commit();
        $this->dispatch('user-created, Email sent to: ' . $userRecord->email);

       return;
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Failed to create user: ' . $e->getMessage());
    }
}

    private function getModelByType(string $type)
    {
        $map = [
            'student'  => Student::class,
            'teacher'  => Teacher::class,
            'guardian' => Guardian::class,
        ];

        $type = strtolower(trim($type));

        if (! array_key_exists($type, $map)) {
            throw new InvalidArgumentException("Invalid type: {$type}");
        }

        return $map[$type];
    }

    private function setTemporaryPassword(User $user, int $length = 12): string
    {
        $plainPassword = Str::random($length);

        $user->update([
            'password' => Hash::make($plainPassword),
            'password_expires_at' => Carbon::now()->addMinutes(10),
        ]);

        return $plainPassword;
    }

   public function lock($school_id)
{
    try {
        $school = School::findOrFail($school_id);
        $school->update(['is_locked' => true]);

        session()->flash('success', 'School locked successfully.');
    } catch (\Exception $e) {
        session()->flash('error', 'Failed to lock school: ' . $e->getMessage());
    }
}

public function unlock($school_id)
{
    try {
        $school = School::findOrFail($school_id);
        $school->update(['is_locked' => false]);

        session()->flash('success', 'School unlocked successfully.');
    } catch (\Exception $e) {
        session()->flash('error', 'Failed to unlock school: ' . $e->getMessage());
    }
}

    public function render()
    {
        $query = School::query();
        if ($this->schoolSearch) {
            $query->where('school_name', 'like', "%{$this->schoolSearch}%");
        }
        $this->schools = $query->take(10)->get();

        $users = User::with('school:id,school_name,is_locked')
            ->when(
                $this->search,
                fn($q) =>
                $q->where('email', 'like', "%{$this->search}%")
                    ->orWhere('name', 'like', "%{$this->search}%")
                    ->orWhereHas(
                        'school',
                        fn($s) =>
                        $s->where('school_name', 'like', "%{$this->search}%")
                    )
            )
            ->latest()
            ->paginate(12);



        return view('livewire.admin.pages.users', compact('users'));
    }
}

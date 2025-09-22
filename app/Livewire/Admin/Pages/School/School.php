<?php

namespace App\Livewire\Admin\Pages\School;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\School as SchoolModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

#[Layout('layouts.app')]
#[Title('School')]
class School extends Component
{
    use WithFileUploads;

    public $school;
    public $newLogo;
    public $editingSchoolId;
    public $showEdit = false; // toggle edit state
    public $school_name, $school_head_title, $address,$motto,  $phone_no, $date_of_establishment, $proprietor, $type,$email;

   public function mount()
{
    if (Auth::check() && Auth::user()->school) {
        $this->school = SchoolModel::find(Auth::user()->school->id);

        if ($this->school) {
            $this->school_name = $this->school->school_name;
            $this->address = $this->school->address;
          $this->email = $this->school->email;
          $this->motto = $this->school->motto;
            $this->phone_no = $this->school->phone_no;
            $this->date_of_establishment = $this->school->date_of_establishment
                ? \Carbon\Carbon::parse($this->school->date_of_establishment)->format('Y-m-d')
                : null;
            $this->school_head_title = $this->school->school_head_title;
            $this->proprietor = $this->school->proprietor;
            $this->type = $this->school->type;
             $this->editingSchoolId = $this->school->id;
        }
    }
}

public function updateSchool()
{
    $this->validate([
        'school_name' => 'required|string|max:255',
        'address' => 'nullable|string|max:255',
        'email'                 => [
                'required',
                'email',
                Rule::unique('schools', 'email')->ignore($this->editingSchoolId),
            ],
        'phone_no' => 'nullable|string|max:20',
        'date_of_establishment' => 'nullable|date',
        'proprietor' => 'nullable|string|max:255',
        'type' => 'required|in:primary,secondary',
        'motto'=> 'required',
        'school_head_title'=>'required'
    ]);

    $this->school->update([
        'school_name' => $this->school_name,
        'address' => $this->address,
        'email' => $this->email,
        'phone_no' => $this->phone_no,
        'date_of_establishment' => $this->date_of_establishment,
        'proprietor' => $this->proprietor,
        'type' => $this->type,
        'motto'=> $this->motto,
        'school_head_title' =>$this->school_head_title,
    ]);

    $this->school->refresh();

    session()->flash('status', '✅ School details updated successfully!');
    $this->dispatch('close-modal', 'editSchool');
}


    public function updateLogo()
    {
        $this->validate([
            'newLogo' => 'image|max:2048', // max 2MB
        ]);

        if ($this->school) {
            // Delete old logo if it exists
            if ($this->school->school_logo && Storage::disk('public')->exists($this->school->school_logo)) {
                Storage::disk('public')->delete($this->school->school_logo);
            }

            // Store new logo
            $path = $this->newLogo->store('logos', 'public');

            // Update DB
            $this->school->update([
                'school_logo' => $path,
            ]);

            $this->school->refresh();
            $this->newLogo = null;
            $this->showEdit = false;

            session()->flash('status', '✅ School logo updated successfully!');
        }
    }

    public function render()
    {
        return view('livewire.admin.pages.school.school');
    }
}

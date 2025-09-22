<?php

namespace App\Livewire\Admin\Pages\School;

use App\Models\LessonNote;
use App\Models\Level;
use App\Models\Year;
use App\Models\Week;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title("Teacher's Lesson Notes")]
class TeacherLessonNote extends Component
{
    use WithFileUploads, WithPagination;

    public $selectedLevel = null;
    public $noteFile;
    public $search = '';
    public $term;
    public $activeYear;
    public $selectedWeek = null;
    public $numberOfWeeks;
    public $showUploadForm = false;


    public function mount()
    {
        $this->activeYear = Year::where('status', 'active')
            ->where('school_id', Auth::user()->school_id)
            ->first();

        if ($this->activeYear) {
            $this->term = $this->activeYear->term ?? null;
        }
    }

    public function selectWeek($levelId, $weekId)
    {
        $this->selectedLevel = Level::findOrFail($levelId);
        $this->selectedWeek = $weekId;

        $this->reset('noteFile');

    }

    public function uploadNote()
    {
       $this->validate([
    'noteFile' => 'required|mimes:pdf|max:10240', // max 10MB
], [
    'noteFile.required' => 'Please select a file to upload.File must be a pdf file | The file size must not exceed 10MB.',
    'noteFile.mimes'    => 'The file must be a PDF.',
    'noteFile.max'      => 'The file size must not exceed 10MB.',
]);


        if (!$this->activeYear) {
            session()->flash('error', 'No active academic year found.');
            return;
        }

        $existingNote = LessonNote::where('level_id', $this->selectedLevel->id)
            ->where('school_id', Auth::user()->school_id)
            ->where('term', $this->term)
            ->where('week', $this->selectedWeek)
            ->where('year_id', $this->activeYear->id)
            ->first();

        if ($existingNote) {
            session()->flash('error', 'Remove the existing note before uploading a new one.');
            return;
        }

        $path = $this->noteFile->store('lesson-notes', 'public');

        LessonNote::create([
            'level_id'      => $this->selectedLevel->id,
            'school_id'     => Auth::user()->school_id,
            'written_by_id' => Auth::id(),
            'note_url'      => $path,
            'term'          => $this->term,
            'week'          => $this->selectedWeek,
            'year_id'       => $this->activeYear->id,
        ]);

        session()->flash('status', 'Lesson note uploaded successfully!');
        $this->reset(['noteFile', 'selectedLevel', 'selectedWeek']);
    }

    public function removeNote($noteId)
    {
        $note = LessonNote::findOrFail($noteId);

        if ($note->note_url && Storage::disk('public')->exists($note->note_url)) {
            Storage::disk('public')->delete($note->note_url);
        }

        $note->delete();

        session()->flash('status', 'Lesson note removed successfully!');
    }

    public function saveWeeks()
    {
        $this->validate([
            'term'          => 'required|in:first,second,third',
            'numberOfWeeks' => 'required|integer|min:1|max:52',
        ]);

        if (!$this->activeYear) {
            session()->flash('error', 'No active academic year found.');
            return;
        }

        for ($i = 1; $i <= $this->numberOfWeeks; $i++) {
            Week::updateOrCreate([
                'school_id' => Auth::user()->school_id,
                'year_id'   => $this->activeYear->id,
                'term'      => $this->term,
                'number'    => $i,
            ]);
        }

        session()->flash('status', 'Weeks saved successfully!');
        $this->reset('numberOfWeeks');
    }

    public function deleteWeek($weekId)
    {
        $week = Week::findOrFail($weekId);

        // Optionally delete associated notes
        $week->lessonNotes()->each(function ($note) {
            if ($note->note_url && Storage::disk('public')->exists($note->note_url)) {
                Storage::disk('public')->delete($note->note_url);
            }
            $note->delete();
        });

        $week->delete();

        session()->flash('status', 'Week deleted successfully!');
    }

   public function cancelUpload()
{
   
      $this->reset(['selectedLevel', 'selectedWeek', 'noteFile']);
    $this->resetValidation();
    
     

}

    public function render()
    {
        $levels = Level::where('school_id', Auth::user()->school_id)
            ->where('name', 'like', "%{$this->search}%")
            ->with(['lessonNotes' => function ($query) {
                if ($this->activeYear) {
                    $query->where('year_id', $this->activeYear->id)
                        ->where('term', $this->term);
                }
            }, 'lessonNotes.writer'])
            ->paginate(6);

        $weeks = collect();
        if ($this->activeYear) {
            $weeks = Week::where('school_id', Auth::user()->school_id)
                ->where('year_id', $this->activeYear->id)
                ->orderBy('term')
                ->orderBy('number')
                ->get()
                ->groupBy('term');
        }

        return view('livewire.admin.pages.school.teacher-lesson-note', [
            'levels'     => $levels,
            'activeYear' => $this->activeYear,
            'term'       => $this->term,
            'weeks'      => $weeks,
        ]);
    }
}

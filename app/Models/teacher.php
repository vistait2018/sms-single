<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'address',
        'qualification',
        'date_of_employement',
        'sex',
        'dob',
        'phone_no',
        'religion',
        'national',
        'state_of_origin',
        'previous_school_name',
        'lga',
        'level_id',
        'user_id',
        'school_id',
        'avatar', // add avatar support
    ];

    public function level(): HasOne
    {
        return $this->hasOne(Level::class, 'teacher_id'); // a class has one class teacher
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'teacher_subject', 'teacher_id', 'subject_id')
            ->withTimestamps();
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

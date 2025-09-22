<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'avatar',
        'details',
        'sign_url',
    ];

    public function level(): HasOne
    {
        return $this->hasOne(Level::class, 'teacher_id'); // a class has one class teacher
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'subject_teachers', 'teacher_id', 'subject_id')
            ->using(SubjectTeacher::class)  // 👈 use custom pivot
            ->withPivot(['year_id', 'active', 'level_id'])
            ->withTimestamps();
    }


    public function levels(): BelongsToMany
    {
        return $this->belongsToMany(Level::class, 'level_teacher', 'teacher_id', 'level_id')
            ->withPivot(['year_id', 'active'])
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

    public function salaries(): HasMany
    {
        return $this->hasMany(Salary::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(TeacherPayment::class);
    }

    // Only active salary (hasOne relationship shortcut)
    public function activeSalary()
    {
        return $this->hasOne(Salary::class, 'teacher_id')->where('active', true);
    }
}

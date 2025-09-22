<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'address',
        'sex',
        'dob',
        'lin_no',
        'phone_no',
        'religion',
        'national',
        'state_of_origin',
        'previous_school_name',
        'lga',
        'user_id',
        'school_id',
        'avatar'

    ];


    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

   public function departments(): BelongsToMany
{
    return $this->belongsToMany(
        Department::class,
        'department_student',   // pivot table
        'student_id',           // FK on pivot pointing to student
        'department_id'         // FK on pivot pointing to department
    )->withTimestamps();
}


    public function levels(): BelongsToMany
    {
       return $this->belongsToMany(Level::class, 'level_student', 'student_id', 'level_id')
    ->withPivot(['year_id', 'department_id','active'])
    ->withTimestamps();
    }
    public function user(): BelongsTo
{
    return $this->belongsTo(User::class, 'user_id');
}


public function results():HasMany
{
    return $this->hasMany(Result::class, 'student_id');

}

public function resultExtras():HasMany
{
    return $this->hasMany(ResultExtra::class, 'student_id');
}

}
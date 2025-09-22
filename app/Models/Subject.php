<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    /** @use HasFactory<\Database\Factories\SubjectFactory> */
    use HasFactory;

     protected $fillable = [
        'name',
        'school_id'
    ];

     public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
     public function departments(): BelongsToMany
    {
        return $this->belongsToMany(Department::class,'department_subject','subject_id','department_id')
        ->withTimestamps();
    }


public function teachers(): BelongsToMany
{
    return $this->belongsToMany(Teacher::class, 'subject_teachers', 'subject_id', 'teacher_id')
        ->using(SubjectTeacher::class)  // 👈 use custom pivot
        ->withPivot(['year_id', 'active', 'level_id'])
        ->withTimestamps();
}


}

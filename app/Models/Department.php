<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory;


    protected $fillable = [
        'name',
        'school_id'
    ];
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'department_subject', 'department_id', 'subject_id')
            ->withTimestamps();
    }
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'department_student', 'department_id', 'student_id')
            ->withTimestamps();
    }

     public function levels(): BelongsToMany
{
    return $this->belongsToMany(Level::class, 'department_level', 'department_id', 'level_id')
        ->withPivot('year_id')
        ->withTimestamps();
}

}

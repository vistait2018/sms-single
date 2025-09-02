<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Level extends Model
{
    /** @use HasFactory<\Database\Factories\LevelFactory> */
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
       
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function students(): BelongsToMany
    {
       return $this->belongsToMany(Student::class, 'level_student', 'level_id', 'student_id')
    ->withPivot(['year_id', 'department_id','active'])
    ->withTimestamps();
    }

   public function teacher(): BelongsTo
{
    return $this->belongsTo(Teacher::class, 'teacher_id');
}

    public function departments(): BelongsToMany
{
    return $this->belongsToMany(Department::class, 'department_level', 'level_id', 'department_id')
        ->withPivot('year_id')
        ->withTimestamps();
}

}

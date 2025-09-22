<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class SubjectTeacher extends Pivot
{
    protected $table = 'subject_teachers'; // 👈 must match your pivot table

    protected $fillable = [
        'teacher_id',
        'subject_id',
        'level_id',
        'year_id',
        'active',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class, 'level_id');
    }
}

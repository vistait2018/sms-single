<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelStudent extends Model
{
    protected $table = 'level_student';
    protected $fillable = [
        'department_id',
        'student_id',
        'year_id',
        'level_id',
        'active',
        'created_at',
        'updated_at'
    ];
}

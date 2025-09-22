<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAffective extends Model
{
    /** @use HasFactory<\Database\Factories\StudentAffectiveFactory> */
    use HasFactory;
    protected $table= 'school_affectives';
    protected $fillable = [
         'school_id', 'name', 'grade_level',
    ];
}

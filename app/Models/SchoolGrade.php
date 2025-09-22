<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolGrade extends Model
{
    /** @use HasFactory<\Database\Factories\SchoolGradeFactory> */
    use HasFactory;
    protected $table='school_grades';
    protected $fillable = ['school_id', 'grade_name', 'min_level', 'max_level' ];
     public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}

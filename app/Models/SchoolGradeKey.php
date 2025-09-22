<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SchoolGradeKey extends Model
{
    /** @use HasFactory<\Database\Factories\SchoolGradeKeyFactory> */
    use HasFactory;
    protected $table='school_grade_keys';

    protected $fillable = [
        'school_id', 'key_name', 'grade_level', 
    ];

     public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}



<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResultExtra extends Model
{
    /** @use HasFactory<\Database\Factories\ResultExtraFactory> */
    use HasFactory;
    protected $table='result_extras';
    protected $fillable = [
        'student_id', 'year_id', 'term', 'affective_grade', 'psychomotor_grade', 'comment'
    ];

    public function student():BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}

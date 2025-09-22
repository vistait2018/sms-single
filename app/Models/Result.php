<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
     use HasFactory;

    protected $fillable = [
        'student_id', 'year_id', 'term_id', 'subject_id',
        'ca', 'exam', 'school_id', 'user_id',
    ];

    public function student(): BelongsTo { return $this->belongsTo(Student::class); }
    public function subject(): BelongsTo { return $this->belongsTo(Subject::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}

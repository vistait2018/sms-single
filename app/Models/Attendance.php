<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;
    protected $casts = [
    'present' => 'boolean',
];

    protected $fillable = [
       'year_id', 'student_id','level_id','week_id','date','session','present','school_id'
    ];

    public function student(): BelongsTo { return $this->belongsTo(Student::class); }
    public function level(): BelongsTo { return $this->belongsTo(Level::class); }
    public function week(): BelongsTo { return $this->belongsTo(WeekAttendance::class); }
}
